<?php

namespace App\Service\CurrencyExchange;

use App\Service\DataTransferObject\ExchangeRate;

class CurrencyExchangeService
{
    public function __construct(private readonly ExchangeRateProviderInterface $provider)
    {
    }

    public function getExchangeRate(string $transactionCurrency): ExchangeRate
    {
        return $this->provider->getExchangeRates()->getExchangeRateForCurrency($transactionCurrency);
    }
}
