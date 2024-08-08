<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\ProductExtractor; // Assicurati di importare il servizio
use App\Models\Competitor;
use DOMDocument;
use DOMXPath;

class ExtractProductLinks extends Command
{
    protected $signature = 'extract:product-links {url}';
    protected $description = 'Extract product links from the given page and log them';
    private $productExtractor;

    public function __construct(ProductExtractor $productExtractor)
    {
        parent::__construct();
        $this->productExtractor = $productExtractor;
    }

    public function handle()
    {
        $url = $this->argument('url');

        try {
            $response = Http::withOptions(['verify' => false])->get($url);

            if ($response->successful()) {
                $htmlContent = $response->body();
                $links = array_unique($this->extractLinks($htmlContent));

                $count = 0;
                foreach ($links as $link) {
                    if ($count >= 20) {
                        break;
                    }

                    $responseLinks = Http::withOptions([
                        'verify' => false,
                    ])->get($link);

                    if ($responseLinks->successful()) {
                        $productDetails = $this->productExtractor->extractProductDetails($responseLinks->body());

                        Competitor::create([
                            'competitor' => $this->extractCompetitorName($url),
                            'sku' => $productDetails['sku'],
                            'product_title' => $productDetails['title'],
                            'sale_price' => $productDetails['price'],
                        ]);

                        $count++;
                    } else {
                        $this->error("Failed to fetch the HTML content for link: $link");
                    }
                }

                $this->info('Product links have been extracted and logged successfully!');
            } else {
                $this->error('Failed to fetch the HTML content.');
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }

    private function extractLinks($html)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query('//a[contains(@href, "product_info.php")]');

        $links = [];
        foreach ($nodes as $node) {
            $href = $node->getAttribute('href');
            if (!empty($href)) {
                $links[] = $href;
            }
        }

        return $links;
    }

    private function extractCompetitorName($url)
    {
        $urlComponents = parse_url($url);
        return $urlComponents['host'] ?? 'N/A';
    }
}
