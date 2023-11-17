<?php

namespace App\Service\CurrencyExchange;

interface ExchangeRateProviderInterface
{
    public function getExchangeRates(): ExchangeRateCollection;
}
