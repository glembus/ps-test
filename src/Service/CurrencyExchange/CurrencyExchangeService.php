<?php

namespace App\Service\CurrencyExchange;

use App\ValueObject\TransactionInterface;

class CurrencyExchangeService
{
    public function __construct(
        private readonly ExchangeRateProviderInterface $provider
    )
    {

    }

    public function convertToCurrency(TransactionInterface $transaction, string $currency): TransactionInterface
    {
        $rate = $this->provider->getExchangeRates()->getExchangeRateForCurrency($currency);

        return $transaction->convert($rate);
    }
}