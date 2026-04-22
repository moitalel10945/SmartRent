<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Services\RentCalculationService;

class TenantDashboardController extends Controller
{
    public function __construct(
        protected RentCalculationService $calculationService
    ) {}

    public function index()
        {
            $tenancy = auth()->user()
                ->tenancies()
                ->where('active', true)
                ->with('unit.property')
                ->first();

            $balance = $tenancy
                ? $this->calculationService->calculate($tenancy)
                : null;

            return view('tenant.dashboard', compact('tenancy', 'balance'));
        }

    public function unit()
        {
            $tenancy = auth()->user()
                ->tenancies()
                ->where('active', true)
                ->with('unit.property')
                ->first();

            return view('tenant.unit', compact('tenancy'));
        }
}