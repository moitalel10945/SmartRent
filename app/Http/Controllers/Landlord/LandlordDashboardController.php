<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Services\LandlordDashboardService;

class LandlordDashboardController extends Controller
{
    public function __construct(
        protected LandlordDashboardService $dashboardService
    ) {}

    public function index()
    {
        $summary = $this->dashboardService->getSummary(auth()->user());

        return view('landlord.dashboard', compact('summary'));
    }
}