<?php

namespace App\Services;

use App\Models\Tenancy;
use App\Models\Unit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TenancyService
{
    public function assignTenant(array $data): Tenancy
    {
        $unit = Unit::findOrFail($data['unit_id']);

        if ($unit->activeTenancy) {
            throw ValidationException::withMessages([
                'unit_id' => 'This unit already has an active tenant.',
            ]);
        }

        if (Carbon::parse($data['end_date'])->lte(Carbon::parse($data['start_date']))) {
            throw ValidationException::withMessages([
                'end_date' => 'End date must be after the start date.',
            ]);
        }

        return DB::transaction(function () use ($data, $unit) {
            $tenancy = Tenancy::create([
                'tenant_id'            => $data['tenant_id'],
                'unit_id'              => $unit->id,
                'start_date'           => $data['start_date'],
                'end_date'             => $data['end_date'],
                'rent_amount_snapshot' => $unit->rent_amount,
            ]);

            $unit->update(['status' => 'occupied']);

            return $tenancy;
        });
    }

    public function endTenancy(Tenancy $tenancy): Tenancy
    {
        return DB::transaction(function () use ($tenancy) {
            $tenancy->update([
                'end_date' => now(),
                'active'   => false,
            ]);

            $tenancy->unit->update(['status' => 'vacant']);

            return $tenancy->fresh();
        });
    }
}