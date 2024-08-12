<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Competitor;
use App\ScrapingStrategies\ScrapingStrategyFactory;

class CrawlProduct extends Command
{
    protected $signature = 'crawl-ecommerce:product {url}';
    protected $description = 'Crawl the specified product page and log its details';

    public function handle()
    {
        $url = $this->argument('url');

        // Determina la strategia di scraping in base all'URL
        $productExtractor = ScrapingStrategyFactory::createStrategy($url);

        if (!$productExtractor) {
            $this->error('No valid scraping strategy found for this URL.');
            return;
        }

        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get($url);

            if ($response->successful()) {
                $htmlPage = $response->body();

                // Estrai i dati utilizzando la strategia selezionata
                $data = $productExtractor->extractData($htmlPage);

                // Salva i dati nel database
                Competitor::create([
                    'competitor' => $data['competitor'],
                    'sku' => $data['sku'],
                    'product_title' => $data['title'],
                    'sale_price' => $data['price'],
                ]);

                Log::channel('product')->info('Product Details:', $data);

                $this->info('Product details have been logged successfully!');
            } else {
                $this->error('Failed to fetch the HTML content.');
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
