<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ProxyRotator
{
    protected $proxies;

    public function __construct()
    {
        // Lista dei proxy
        $this->proxies = [
            'http://proxy1.example.com:8080',
            'http://proxy2.example.com:8080',
            'http://proxy3.example.com:8080',
        ];
    }

    public function getNextProxy()
    {
        // Recupera l'indice corrente del proxy dalla cache, default a 0
        $index = Cache::get('proxy_index', 0);
        $proxy = $this->proxies[$index];

        // Aggiorna l'indice per il prossimo utilizzo
        $nextIndex = ($index + 1) % count($this->proxies);
        Cache::put('proxy_index', $nextIndex, now()->addMinutes(10));

        return $proxy;
    }
}
