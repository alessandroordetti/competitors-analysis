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

        // Cerca l'elemento con itemprop="name" per il titolo del prodotto
        $titleNode = $xpath->query('//*[@itemprop="name"]/h1')->item(0);
        $title = $titleNode ? $titleNode->textContent : 'N/A';

        $offerPriceNode = $xpath->query('//*[contains(@class, "product-offert-price")]')->item(0);
        $basePriceNode = $xpath->query('//*[contains(@class, "product-base-price ")]')->item(0);

        // Estrai il prezzo base e rimuovi il simbolo dell'euro
        $basePrice = $basePriceNode ? str_replace('€', '', $basePriceNode->textContent) : 'N/A';
        $price = trim($basePrice) ? (float) trim($basePrice) : 0.0;


        // Cerca l'elemento con class="container-sidebar-right-product-code" per lo SKU
        $skuNode = $xpath->query('//meta[@itemprop="sku"]')->item(0);
        $sku = $skuNode ? $skuNode->getAttribute('content') : 'N/A';

        // Rimuove eventuali spazi bianchi
        return [
            'title' => trim($title),
            'price' => trim($price),
            'sku' => trim($sku)
        ];
    }
}
