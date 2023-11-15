<?php

namespace App\Service\CurrencyExchange;

use App\Service\DataTransferObject\ConvertInterface;

class CurrencyExchangeService
{
    public function __construct(private readonly ExchangeRateProviderInterface $provider)
    {
    }

    public function convertToCurrency(ConvertInterface $transaction, string $currency): ConvertInterface
    {
        $rate = $this->provider->getExchangeRates()->getExchangeRateForCurrency($currency);

        return $transaction->convert($rate);
    }
}