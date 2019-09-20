<?php

namespace App\Console;

use App\Console\Commands\NewsFetch;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        NewsFetch::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('news:fetch')
            ->everyFiveMinutes()
            ->timezone('Asia/Tehran')
            ->between('7:00', '14:30');

        $schedule->command('news:fetch')
            ->hourly()
            ->timezone('Asia/Tehran')
            ->between('14:30', '20:00');

        $schedule->command('news:fetch')
            ->dailyAt('00:00')
            ->timezone('Asia/Tehran');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
