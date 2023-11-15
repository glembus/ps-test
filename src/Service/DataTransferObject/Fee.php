<?php

namespace App\Service\DataTransferObject;

class Fee implements ConvertInterface
{
    public function __construct(private readonly float $value, private readonly string $currency)
    {
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function convert(ExchangeRate $rate): static
    {
        if ($rate->getCurrency() === $this->currency) {
            return $this;
        }

        return new static($this->value * $rate->getRate(), $rate->getCurrency());
    }

    public function __toString(): string
    {
        return round($this->value, 2);
    }
}