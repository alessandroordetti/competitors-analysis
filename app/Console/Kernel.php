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
        // crawl-ecommerce:product "https://www.centrochitarre.com/martin-d-45-reimagined-dm06600646.html"
        // Pianifica il job CrawlProduct per essere eseguito ogni minuto
        $schedule->command('crawl-ecommerce:product "https://www.cosmomusic.ca/martin-d-45-acoustic-guitar---natural/p"')->everyMinute();
        $schedule->command('crawl-ecommerce:product "https://www.ginomusica.it/it/martin-d45-reimagined-p-7399.html?srsltid=AfmBOoqBwdcr1dLY05DZHRfRfAj_WOjSbWLPskquaS8tGX_fCftVHX5K"')->everyMinute();
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
