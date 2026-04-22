<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTenancyRequest;
use App\Models\Property;
use App\Models\Tenancy;
use App\Models\User;
use App\Services\TenancyService;

class TenancyController extends Controller
{
    public function __construct(protected TenancyService $tenancyService)
    {
    }

    public function index()
    {
        $landlordPropertyIds = auth()->user()
            ->properties()
            ->pluck('id');

        $tenancies = Tenancy::with(['tenant', 'unit.property'])
            ->whereHas('unit', function ($query) use ($landlordPropertyIds) {
                $query->whereIn('property_id', $landlordPropertyIds);
            })
            ->latest()
            ->get();

        return view('landlord.tenancies.index', compact('tenancies'));
    }

    public function create()
        {
            $tenants = User::where('role', 'tenant')
                ->whereDoesntHave('tenancies', function ($q) {
                    $q->where('active', true);
                })
                ->get();

            $units = auth()->user()
                ->properties()
                ->with('units')
                ->get()
                ->pluck('units')
                ->flatten()
                ->where('status', 'vacant');

            return view('landlord.tenancies.create', compact('tenants', 'units'));
        }

    public function store(StoreTenancyRequest $request)
    {
        $this->tenancyService->assignTenant($request->validated());

        return redirect()
            ->route('landlord.tenancies.index')
            ->with('success', 'Tenant assigned successfully.');
    }

    public function show(Tenancy $tenancy)
    {
        $this->authorize('view', $tenancy);
        return view('landlord.tenancies.show', compact('tenancy'));
    }

    public function destroy(Tenancy $tenancy)
    {
        $this->authorize('modify', $tenancy);
        $this->tenancyService->endTenancy($tenancy);

        return redirect()
            ->route('landlord.tenancies.index')
            ->with('success', 'Tenancy ended successfully.');
    }
}