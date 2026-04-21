<?php

use App\Models\Payment;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function () {
    Payment::expireStale();
})->everyFifteenMinutes();

Schedule::command('queue:prune-failed --hours=48')->daily();