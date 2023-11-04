<?php

namespace App\Service\CurrencyExchange\Provider;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExternalProvider
{
    private array $rates = [];

    private bool $rateLoaded = false;

    public function __construct(private HttpClientInterface $httpClient ,private string $currencyExchangeRateUrl)
    {
    }

    private function getRates(): array
    {
        if (!$this->rateLoaded) {
            $this->loadRates();
        }

        return $this->rates;
    }

    private function loadRates(): array
    {
        $this->rates = $this->httpClient->request('GET', $this->currencyExchangeRateUrl)->toArray();
        $this->rateLoaded = true;
    }
}