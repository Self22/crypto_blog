<?php

namespace App\Console;

use App\ParseLink;
use App\UniqText;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);


        $schedule->call(function () {
            ParseLink::parse_coindesk();
        })->hourly();

        $schedule->call(function () {
            ParseLink::parse_cryptonews();
        })->hourly();

        $schedule->call(function () {
            UniqText::create_uniq_news();
        })->hourly();


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
