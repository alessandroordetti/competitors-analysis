<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Competitor;
use App\Models\BestCompetitor;
use Illuminate\Support\Facades\DB;

class FindBestCompetitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:find-best-competitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Look for the best competitor with lowest prices for each SKU';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Cancella i record esistenti nella tabella best_competitors
        BestCompetitor::truncate();

        // Query per trovare il competitor con il prezzo più basso per ogni SKU
        $lowestPrices = Competitor::select('sku', 'product_title', 'competitor', DB::raw('MIN(sale_price) as lowest_price'))
            ->whereIn('competitor', ['Cosmomusic', 'CentroChitarre'])
            ->groupBy('sku', 'product_title')
            ->orderBy('lowest_price', 'ASC')
            ->get();

        foreach ($lowestPrices as $price) {
            $winner = Competitor::where('sku', $price->sku)
                ->where('sale_price', $price->lowest_price)
                ->first();

            BestCompetitor::create([
                'sku' => $price->sku,
                'product_title' => $price->product_title,
                'sale_price' => $price->lowest_price,
                'winner_competitor' => $winner->competitor,
            ]);
        }

        $this->info('Best competitors found and stored successfully.');
    }
}
