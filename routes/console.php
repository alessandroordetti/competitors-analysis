<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('crawl-ecommerce:product "https://www.cosmomusic.ca/martin-d-45-acoustic-guitar---natural/p"')->everyMinute();
Schedule::command('crawl-ecommerce:product "https://www.ginomusica.it/it/martin-d45-reimagined-p-7399.html?srsltid=AfmBOoqBwdcr1dLY05DZHRfRfAj_WOjSbWLPskquaS8tGX_fCftVHX5K"')->everyMinute();
