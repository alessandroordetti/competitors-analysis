<?php

namespace App\ScrapingStrategies;

class ScrapingStrategyFactory
{
    public static function createStrategy($url)
    {
        if (strpos($url, 'centrochitarre.com') !== false) {
            return new ECommerceAScrapingStrategy();
        } elseif (strpos($url, 'strumentimusicali.net') !== false) {
            return new ECommerceBScrapingStrategy();
        }
        return null;
    }
}
