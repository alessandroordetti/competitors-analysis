<?php

namespace App\Console;

use Illuminate\Console\Command;
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
    ];

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
