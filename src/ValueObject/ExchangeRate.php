<?php

namespace App\ValueObject;

final class ExchangeRate
{
    public function __construct(private readonly float $rate, private readonly string $currency) {}

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}