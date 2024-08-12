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

        $titleNode = $xpath->query('//*[@id="productName"]')->item(0);
        $title = $titleNode ? $titleNode->textContent : 'N/A';

        /* $offerPriceNode = $xpath->query('//*[contains(@class, "old-price")]')->item(0); */
        $basePriceNode = $xpath->query('//*[contains(@class, "productGeneral")]')->item(0);

        if ($basePriceNode) {
            $basePrice = $basePriceNode->textContent;
            // Rimuovi il simbolo di valuta e spazi non separabili
            $basePrice = preg_replace('/[^\d,.\s]/u', '', $basePrice);
            // Rimuovi spazi non separabili e normali spazi
            $basePrice = str_replace(["\xC2\xA0", ' '], '', $basePrice);
            // Sostituisci eventuali virgole con punti per supportare i decimali
            $basePrice = str_replace(',', '.', $basePrice);
            // Converti in float
            $price = is_numeric($basePrice) ? (float) $basePrice : 0.0;
        } else {
            $price = 0.0;
        }

        $skuNode = $xpath->query('//*[contains(@class, "productInfoTopDetail")]/span')->item(0);
        $sku = $skuNode ? $skuNode->textContent : 'N/A';

        $data = [
            'competitor' => 'GinoMusica',
            'title' => trim($title),
            'price' => trim($price),
            'sku' => trim($sku)
        ];

        return $data;
    }
}
