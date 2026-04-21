<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Tenancy;
use App\Services\RentCalculationService;

class ArrearsController extends Controller
{
    public function __construct(
        protected RentCalculationService $calculationService
    ) {}

    public function index()
{
    $landlordPropertyIds = auth()->user()
        ->properties()
        ->pluck('id');

    $tenancies = Tenancy::with(['unit.property', 'tenant'])
        ->whereHas('unit', function ($query) use ($landlordPropertyIds) {
            $query->whereIn('property_id', $landlordPropertyIds);
        })
        ->where('active', true)
        ->get();

    $summary = $tenancies->map(function (Tenancy $tenancy) {
        $balance = $this->calculationService->calculate($tenancy);
        return [
            'tenancy' => $tenancy,
            'balance' => $balance,
        ];
    });

    $totalArrears = $summary->sum(fn($row) => $row['balance']['arrears']);
    $totalPaid    = $summary->sum(fn($row) => $row['balance']['paid_total']);

    return view('landlord.arrears.index', compact('summary', 'totalArrears', 'totalPaid'));
}
}