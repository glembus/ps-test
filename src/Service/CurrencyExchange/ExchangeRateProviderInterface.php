<?php

namespace App\Service\CurrencyExchange\Provider;

use App\Service\CurrencyExchange\ExchangeRateCollection;
use App\ValueObject\ExchangeRate;

interface ExchangeRateProviderInterface
{
    public function getExchangeRates(string $currency): ExchangeRateCollection;
}