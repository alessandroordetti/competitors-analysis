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

        $titleNode = $xpath->query('//*[contains(@class, "vtex-store-components-3-x-productBrand")]')->item(0);
        $title = $titleNode ? $titleNode->textContent : 'N/A';

        $priceNode = $xpath->query('//*[contains(@class, "vtex-product-price-1-x-currencyContainer")]')->item(0);
        // Rimuovi il simbolo di valuta e le virgole dalle migliaia
        $priceText = str_replace(['$', ','], '', $priceNode->textContent);

        // Converti la stringa in un numero float, utilizzando un punto come separatore decimale
        $price = number_format((float)$priceText, 2, '.', '');

        $skuNode = $xpath->query('//*[contains(@class, "cosmo-store-theme-8-x-separator")]/following-sibling::span')->item(0);
        if ($skuNode) {
            // Estrai il testo dopo "Model: "
            $skuText = trim($skuNode->textContent);
            if (strpos($skuText, 'Model: ') !== false) {
                $sku = trim(str_replace('Model: ', '', $skuText));
            }
        }

        return [
            'competitor' => 'Cosmomusic',
            'title' => trim($title),
            'price' => trim($price),
            'sku' => trim($sku)
        ];
    }
}
