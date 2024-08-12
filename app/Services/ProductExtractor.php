<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;


class ProductExtractor
{
    public function extractProductDetails(string $html): array
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        $titleNode = $xpath->query('//*[@itemprop="name"]/h1')->item(0);
        $title = $titleNode ? $titleNode->textContent : 'N/A';

        $offerPriceNode = $xpath->query('//*[contains(@class, "product-offert-price")]')->item(0);
        $basePriceNode = $xpath->query('//*[contains(@class, "product-base-price ")]')->item(0);

        $basePrice = $basePriceNode ? str_replace('€', '', $basePriceNode->textContent) : 'N/A';
        $price = trim($basePrice) ? (float) trim($basePrice) : 0.0;

        $skuNode = $xpath->query('//meta[@itemprop="sku"]')->item(0);
        $sku = $skuNode ? $skuNode->getAttribute('content') : 'N/A';

        return [
            'title' => trim($title),
            'price' => trim($price),
            'sku' => trim($sku)
        ];
    }
}
