<?php

namespace App\Services;

class ApiClient
{
    private $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function request($endpoint, $params = [])
    {
        // Esegui la richiesta all'API
        // ...

        return "Risultato della richiesta API";
    }
}
