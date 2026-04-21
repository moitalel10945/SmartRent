<?php

use App\Http\Controllers\Landlord\ArrearsController;
use App\Http\Controllers\Landlord\LandlordDashboardController;
use App\Http\Controllers\Landlord\PaymentController as LandlordPaymentController;
use App\Http\Controllers\Landlord\PropertyController;
use App\Http\Controllers\Landlord\ReportController;
use App\Http\Controllers\Landlord\TenancyController;
use App\Http\Controllers\Landlord\UnitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tenant\PaymentController as TenantPaymentController;
use App\Http\Controllers\Tenant\PaymentHistoryController;
use App\Http\Controllers\Tenant\TenantDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::middleware('role:landlord')
        ->prefix('landlord')
        ->name('landlord.')
        ->group(function () {

            Route::get('/dashboard', [LandlordDashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('properties', PropertyController::class)
                ->names('properties');

            Route::resource('properties.units', UnitController::class)
                ->names('properties.units');

            Route::resource('tenancies', TenancyController::class)
                ->names('tenancies');

            Route::get('/payments', [LandlordPaymentController::class, 'index'])
                ->name('payments.index');

            Route::get('/arrears', [ArrearsController::class, 'index'])
                ->name('arrears.index');

            Route::get('/reports', [ReportController::class, 'index'])
                ->name('reports.index');
            Route::get('/reports/payments', [ReportController::class, 'payments'])
                ->name('reports.payments');
            Route::get('/reports/payments/export', [ReportController::class, 'exportPayments'])
                ->name('reports.payments.export');
            Route::get('/reports/arrears', [ReportController::class, 'arrears'])
                ->name('reports.arrears');
            Route::get('/reports/arrears/export', [ReportController::class, 'exportArrears'])
                ->name('reports.arrears.export');
            Route::get('/reports/performance', [ReportController::class, 'performance'])
                ->name('reports.performance');
            Route::get('/reports/performance/export', [ReportController::class, 'exportPerformance'])
                ->name('reports.performance.export');
        });

    Route::middleware('role:tenant')
        ->prefix('tenant')
        ->name('tenant.')
        ->group(function () {

            Route::get('/dashboard', [TenantDashboardController::class, 'index'])
                ->name('dashboard.index');

            Route::get('/unit', function () {
                return view('tenant.unit');
            })->name('unit');

            Route::post('/pay', [TenantPaymentController::class, 'store'])
                ->name('payment.store');

            Route::get('/payments', [PaymentHistoryController::class, 'index'])
                ->name('payments.index');

            Route::get('/payments/receipt/{receipt}', [PaymentHistoryController::class, 'show'])
                ->name('payments.receipt');
        });
});

require __DIR__.'/auth.php';