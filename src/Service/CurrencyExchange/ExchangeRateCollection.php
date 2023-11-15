<?php

namespace App\Service\CurrencyExchange;

use App\Service\DataTransferObject\ExchangeRate;

final class ExchangeRateCollection
{
    private \ArrayIterator $rates;

    private readonly \DateTime $date;

    public function __construct(
        private readonly string $baseCurrency = 'EUR',
        string $date,
    ) {
        $this->date = date_create_from_format('Y-m-d', $date);
        $this->rates = new \ArrayIterator();
    }

    public function addExchangeRate(ExchangeRate $rate): self
    {
        $this->rates->offsetSet($rate->getCurrency(), $rate);

        return $this;
    }

    public function getExchangeRateForCurrency(string $currency): ExchangeRate
    {
        $exchangeRate = $this->rates->offsetGet($currency);
        if ($exchangeRate instanceof ExchangeRate) {
            return $exchangeRate;
        }

        throw new \Exception('Invalid currency provided');
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }
}