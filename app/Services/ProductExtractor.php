<?php

namespace App\Services;

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

        // Cerca l'elemento con class="product-offert-price" per il prezzo
        $offerPrice = $xpath->query('//*[contains(@class, "product-offert-price")]')->item(0);
        $basePrice = $xpath->query('//*[contains(@class, "product-base-price")]')->item(0);
        $price = $offerPrice ? (float) str_replace('€', '', $offerPrice->textContent) : (float) str_replace('€', '', $basePrice->textContent);

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
