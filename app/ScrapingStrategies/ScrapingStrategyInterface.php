<?php

namespace App\ScrapingStrategies;

interface ScrapingStrategyInterface
{
    public function extractData(string $htmlContent): array;
}
