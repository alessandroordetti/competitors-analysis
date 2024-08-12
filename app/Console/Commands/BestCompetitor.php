<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class competitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'competitor:find-best';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Confronta i codici SKU e trova il competitor migliore';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
