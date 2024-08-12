<?php

namespace App\ScrapingStrategies;

class ScrapingStrategyFactory
{
    public static function createStrategy($url)
    {
        if (strpos($url, 'ginomusica.it') !== false) {
            return new ECommerceAScrapingStrategy();
        } elseif (strpos($url, 'cosmomusic.ca') !== false) {
            return new ECommerceBScrapingStrategy();
        }
        return null;
    }
}
