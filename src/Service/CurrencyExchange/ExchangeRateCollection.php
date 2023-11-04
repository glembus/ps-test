<?php

namespace App\Service\CurrencyExchange;

use App\ValueObject\ExchangeRate;

final class ExchangeRateCollection
{
    private \ArrayIterator $rates;

    public function __construct(
        private readonly string $baseCurrency = 'EUR',
        private readonly \DateTimeImmutable $date = new \DateTimeImmutable()
    ) {
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

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }
}