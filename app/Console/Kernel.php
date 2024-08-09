<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * I comandi Artisan dell'applicazione.
     *
     * @var array
     */
    protected $commands = [
        // Aggiungi il tuo comando qui
        \App\Console\Commands\WriteLog::class,
        \App\Console\Commands\CrawlProduct::class
    ];

    /**
     * Definisce la pianificazione dei comandi dell'applicazione.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Pianifica il job CrawlProduct per essere eseguito ogni minuto
        $schedule->command('extract:product-links "https://www.strumentimusicali.net/product_info.php/"')->everyMinute();
    }

    /**
     * Registra i comandi Artisan dell'applicazione.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
