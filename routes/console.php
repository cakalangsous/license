<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/*
|--------------------------------------------------------------------------
| Demo Mode Scheduled Tasks
|--------------------------------------------------------------------------
|
| When IS_DEMO=true, the database will be reset daily at midnight.
| This ensures demo users always have fresh data to work with.
|
*/

Schedule::command('demo:reset --force')
    ->daily()
    ->at('00:00')
    ->when(function () {
        return config('app.is_demo');
    })
    ->withoutOverlapping()
    ->runInBackground()
    ->emailOutputOnFailure(env('ADMIN_EMAIL'));
