<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
   protected function schedule(Schedule $schedule)
{
    // FastPay Status Sync (every 10 minutes)
    $schedule->command('sync:fastpay-status')->everyTenMinutes();

    // Membership scheduled mails (daily at 8AM)
    $schedule->command('membership:send-scheduled-mails')->dailyAt('08:00');
}
    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}