<?php

namespace App\ScrapingStrategies;

use App\ScrapingStrategies\ScrapingStrategyInterface;

class ECommerceBScrapingStrategy implements ScrapingStrategyInterface
{

    public function extractData(string $htmlPage): array
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlPage);
        $xpath = new \DOMXPath($dom);

        $titleNode = $xpath->query('//*[@itemprop="name"]/h1')->item(0);
        $title = $titleNode ? $titleNode->textContent : 'N/A';

        $offerPriceNode = $xpath->query('//*[contains(@class, "product-offert-price")]')->item(0);
        $basePriceNode = $xpath->query('//*[contains(@class, "product-base-price ")]')->item(0);

        $basePrice = $basePriceNode ? str_replace('€', '', $basePriceNode->textContent) : 'N/A';
        $price = trim($basePrice) ? (int) str_replace('.', '', $basePrice) : 0.0;

        $skuNode = $xpath->query('//meta[@itemprop="sku"]')->item(0);
        $sku = $skuNode ? $skuNode->getAttribute('content') : 'N/A';

        return [
            'competitor' => 'StrumentiMusicali',
            'title' => trim($title),
            'price' => trim($price),
            'sku' => trim($sku)
        ];
    }
}
