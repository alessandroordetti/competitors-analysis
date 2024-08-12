<?php

namespace App\ScrapingStrategies;

use App\ScrapingStrategies\ScrapingStrategyInterface;

class ECommerceAScrapingStrategy implements ScrapingStrategyInterface
{
    public function extractData(string $htmlPage): array
    {
        // Logica per estrarre i dati da una pagina con una struttura semplice
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlPage);
        $xpath = new \DOMXPath($dom);

        $titleNode = $xpath->query('//*[@class="base"]')->item(0);
        $title = $titleNode ? $titleNode->textContent : 'N/A';

        /* $offerPriceNode = $xpath->query('//*[contains(@class, "old-price")]')->item(0); */
        $basePriceNode = $xpath->query('//*[contains(@class, "final-price")]/span')->item(0);

        $basePrice = $basePriceNode ? str_replace('€', '', $basePriceNode->textContent) : 'N/A';
        $price = trim($basePrice) ? (int) str_replace('.', '', $basePrice) : 0.0;

        $skuNode = $xpath->query('//*[contains(@class, "sku")]')->item(0);
        $sku = $skuNode ? str_replace("SKU:", '', $skuNode->textContent) : 'N/A';

        $data = [
            'competitor' => 'CentroChitarre',
            'title' => trim($title),
            'price' => trim($price),
            'sku' => trim($sku)
        ];

        return $data;
    }
}
