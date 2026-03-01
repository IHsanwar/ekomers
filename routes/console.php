<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\UpdatePendingTransactions;
use App\Console\Commands\AutoCancelPendingOrders;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(UpdatePendingTransactions::class)->everyMinute();
Schedule::command(AutoCancelPendingOrders::class)->dailyAt('00:00');
