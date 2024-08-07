<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class WriteLog extends Command
{
    protected $signature = 'log:write';
    protected $description = 'Crea un file di log con il messaggio "File scritto"';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('File scritto');
        $this->info('Log scritto con successo!');
    }
}
