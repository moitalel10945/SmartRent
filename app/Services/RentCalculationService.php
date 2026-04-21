<?php

namespace App\Services;

use App\Models\Tenancy;
use Illuminate\Support\Carbon;

class RentCalculationService
{
    public function calculate(Tenancy $tenancy): array
    {
        $startDate   = Carbon::parse($tenancy->start_date);
        $today       = Carbon::today();
        $rentAmount  = (float) $tenancy->unit->rent_amount;

        // Count only fully elapsed months since tenancy started
        $monthsElapsed = $startDate->diffInMonths($today);

        // If tenancy started today, nothing is due yet
        if ($monthsElapsed === 0) {
            return [
                'months_elapsed'  => 0,
                'expected_total'  => 0,
                'paid_total'      => 0,
                'arrears'         => 0,
                'is_owing'        => false,
                'is_paid_up'      => true,
            ];
        }

        $expectedTotal = $monthsElapsed * $rentAmount;

        // Only sum completed payments — never pending or failed
        $paidTotal = $tenancy->payments()
            ->where('status', 'completed')
            ->sum('amount');

        $arrears = max(0, $expectedTotal - $paidTotal);

        return [
            'months_elapsed'  => $monthsElapsed,
            'expected_total'  => $expectedTotal,
            'paid_total'      => (float) $paidTotal,
            'arrears'         => $arrears,
            'is_owing'        => $arrears > 0,
            'is_paid_up'      => $arrears <= 0,
        ];
    }
}