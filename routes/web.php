<?php

use App\Http\Controllers\Landlord\PropertyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
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

Route::middleware(['auth'])->group(function(){
    Route::middleware('role:landlord')->prefix('landlord')
    ->name('landlord.')
    ->group(function(){

        Route::get('/dashboard',function(){
            return view('landlord.dashboard');
        })->name('dashboard');

       /* Route::get('/properties',function(){
            return view('landlord.properties');
        })->name('properties');*/

        Route::get('/units',function(){
            return view('landlord.units');
        })->name('units');

        Route::get('/tenancies',function(){
            return view('landlord.tenancies');
        })->name('tenancies');

        Route::get('/payments',function(){
            return view('landlord.payments');
        })->name('payments');

        Route::get('/reports',function(){
            return view('landlord.reports');
        })->name('reports');

        Route::resource('properties',PropertyController::class)->names('properties');

        Route::resource('properties.units', UnitController::class);
    });

    Route::middleware('role:tenant')
    ->prefix('tenant')
    ->name('tenant.')
    ->group(function(){
        Route::get('/dashboard',function(){
            return view('tenant.dashboard');
        })->name('dashboard');

        Route::get('/unit',function(){
            return view('tenant.unit');
        })->name('unit');

        Route::get('/payment',function(){
            return view('tenant.payment');
        })->name('payment');

        Route::get('/pay',function(){
            return view('tenant.pay');
        })->name('pay');
    });

});

require __DIR__.'/auth.php';
