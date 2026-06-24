<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Default command
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// ✅ YOUR MEMBERSHIP MAIL SCHEDULER
Schedule::command('membership:send-scheduled-mails')
    ->dailyAt('08:00')
    ->timezone('Asia/Kolkata'); // optional but recommended