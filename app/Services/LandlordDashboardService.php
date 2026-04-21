<?php

namespace App\Services;

use App\Models\User;
use App\Models\Tenancy;

class LandlordDashboardService
{
    public function __construct(
        protected RentCalculationService $calculationService
    ) {}

    public function getSummary(User $landlord): array
    {
        $propertyIds = $landlord->properties()->pluck('id');

        // --- Occupancy ---
        $totalUnits    = \App\Models\Unit::whereIn('property_id', $propertyIds)->count();
        $occupiedUnits = \App\Models\Unit::whereIn('property_id', $propertyIds)
            ->where('status', 'occupied')
            ->count();
        $vacantUnits      = $totalUnits - $occupiedUnits;
        $occupancyRate    = $totalUnits > 0
            ? round(($occupiedUnits / $totalUnits) * 100)
            : 0;

        // --- Payments ---
        $totalCollected = \App\Models\Payment::whereHas('tenancy.unit', function ($query) use ($propertyIds) {
                $query->whereIn('property_id', $propertyIds);
            })
            ->where('status', 'completed')
            ->sum('amount');

        // --- Arrears across all active tenancies ---
        $activeTenancies = Tenancy::with(['unit.property', 'tenant', 'payments'])
            ->whereHas('unit', function ($query) use ($propertyIds) {
                $query->whereIn('property_id', $propertyIds);
            })
            ->where('active', true)
            ->get();

        $totalArrears  = 0;
        $tenantsPaidUp = 0;
        $tenantsOwing  = 0;
        $tenantSummary = [];

        foreach ($activeTenancies as $tenancy) {
            $balance = $this->calculationService->calculate($tenancy);

            $totalArrears += $balance['arrears'];

            if ($balance['is_owing']) {
                $tenantsOwing++;
            } else {
                $tenantsPaidUp++;
            }

            $tenantSummary[] = [
                'tenancy' => $tenancy,
                'balance' => $balance,
            ];
        }

        return [
            'total_properties'  => $landlord->properties()->count(),
            'total_units'       => $totalUnits,
            'occupied_units'    => $occupiedUnits,
            'vacant_units'      => $vacantUnits,
            'occupancy_rate'    => $occupancyRate,
            'total_collected'   => (float) $totalCollected,
            'total_arrears'     => $totalArrears,
            'tenants_paid_up'   => $tenantsPaidUp,
            'tenants_owing'     => $tenantsOwing,
            'tenant_summary'    => $tenantSummary,
        ];
    }
}