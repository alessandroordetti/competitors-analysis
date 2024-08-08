<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\ProductExtractor;
use App\Models\Competitor;

class CrawlProduct extends Command
{
    protected $signature = 'crawl-strumentimusicali:product {url}';
    protected $description = 'Crawl the specified product page and log its details';

    protected $productExtractor;

    public function __construct(ProductExtractor $productExtractor)
    {
        parent::__construct();
        $this->productExtractor = $productExtractor;
    }

    public function handle()
    {
        $url = $this->argument('url');

        $urlComponents = explode('/', $url);
        $fullName = explode('.', $urlComponents[2]);

        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get($url);

            if ($response->successful()) {
                $htmlContent = $response->body();
                $productDetails = $this->productExtractor->extractProductDetails($htmlContent);

                Competitor::create([
                    'competitor' => $fullName[1],
                    'sku' => $productDetails['sku'],
                    'product_title' => $productDetails['title'],
                    'sale_price' => $productDetails['price'],
                ]);

                Log::channel('product')->info('Product Details:', $productDetails);

                $this->info('Product details have been logged successfully!');
            } else {
                $this->error('Failed to fetch the HTML content.');
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
