<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Property;
use App\Models\Tenancy;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Collection;

class ReportService
{
    public function __construct(
        protected RentCalculationService $calculationService
    ) {}

    public function paymentReport(User $landlord, array $filters): array
    {
        $propertyIds = $landlord->properties()->pluck('id');

        $query = Payment::with(['tenancy.unit.property', 'tenancy.tenant'])
            ->whereHas('tenancy.unit', function ($q) use ($propertyIds) {
                $q->whereIn('property_id', $propertyIds);
            });

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['property_id'])) {
            $query->whereHas('tenancy.unit', function ($q) use ($filters) {
                $q->where('property_id', $filters['property_id']);
            });
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $payments = $query->latest()->get();

        return [
            'payments'        => $payments,
            'total_count'     => $payments->count(),
            'total_collected' => $payments->where('status', 'completed')->sum('amount'),
            'total_failed'    => $payments->where('status', 'failed')->count(),
            'total_pending'   => $payments->where('status', 'pending')->count(),
        ];
    }

    public function arrearsReport(User $landlord, array $filters): array
    {
        $propertyIds = $landlord->properties()->pluck('id');

        $query = Tenancy::with(['unit.property', 'tenant', 'payments'])
            ->whereHas('unit', function ($q) use ($propertyIds) {
                $q->whereIn('property_id', $propertyIds);
            })
            ->where('active', true);

        if (!empty($filters['property_id'])) {
            $query->whereHas('unit', function ($q) use ($filters) {
                $q->where('property_id', $filters['property_id']);
            });
        }

        $tenancies = $query->get();

        $rows = $tenancies
            ->map(function (Tenancy $tenancy) {
                $balance = $this->calculationService->calculate($tenancy);
                return [
                    'tenancy' => $tenancy,
                    'balance' => $balance,
                ];
            })
            ->filter(fn($row) => $row['balance']['arrears'] > 0)
            ->sortByDesc(fn($row) => $row['balance']['arrears'])
            ->values();

        return [
            'rows'          => $rows,
            'total_arrears' => $rows->sum(fn($row) => $row['balance']['arrears']),
            'total_tenants' => $rows->count(),
        ];
    }

    public function propertyPerformanceReport(User $landlord, array $filters): array
    {
        $query = $landlord->properties()->with(['units.tenancies.payments']);

        if (!empty($filters['property_id'])) {
            $query->where('id', $filters['property_id']);
        }

        $properties = $query->get();

        $rows = $properties->map(function (Property $property) use ($filters) {
            $units        = $property->units;
            $totalUnits   = $units->count();
            $occupiedUnits = $units->where('status', 'occupied')->count();

            $activeTenancies = $units
                ->flatMap(fn($unit) => $unit->tenancies->where('active', true));

            $collected = $activeTenancies
                ->flatMap(fn($tenancy) => $tenancy->payments->where('status', 'completed'))
                ->sum('amount');

            // Apply date filter to collected amount
            if (!empty($filters['date_from']) || !empty($filters['date_to'])) {
                $collected = $activeTenancies
                    ->flatMap(fn($tenancy) => $tenancy->payments
                        ->where('status', 'completed')
                        ->when(!empty($filters['date_from']), fn($p) =>
                            $p->filter(fn($pay) => $pay->created_at >= $filters['date_from']))
                        ->when(!empty($filters['date_to']), fn($p) =>
                            $p->filter(fn($pay) => $pay->created_at <= $filters['date_to']))
                    )
                    ->sum('amount');
            }

            $totalArrears = $activeTenancies->sum(function (Tenancy $tenancy) {
                $balance = $this->calculationService->calculate($tenancy);
                return $balance['arrears'];
            });

            return [
                'property'      => $property,
                'total_units'   => $totalUnits,
                'occupied'      => $occupiedUnits,
                'vacant'        => $totalUnits - $occupiedUnits,
                'occupancy_rate' => $totalUnits > 0
                    ? round(($occupiedUnits / $totalUnits) * 100)
                    : 0,
                'collected'     => (float) $collected,
                'arrears'       => $totalArrears,
            ];
        });

        return [
            'rows'            => $rows,
            'total_collected' => $rows->sum('collected'),
            'total_arrears'   => $rows->sum('arrears'),
            'total_units'     => $rows->sum('total_units'),
            'total_occupied'  => $rows->sum('occupied'),
        ];
    }
}