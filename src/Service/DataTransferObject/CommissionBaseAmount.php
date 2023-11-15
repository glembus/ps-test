<?php

namespace App\Service\DataTransferObject;

final class CommissionBaseAmount implements ConvertInterface
{
    public function __construct(private readonly float $value, private readonly string $currency)
    {
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function convert(ExchangeRate $rate): static
    {
        if ($rate->getCurrency() === $this->currency) {
            return $this;
        }

        return new self($this->value * $rate->getRate(), $rate->getCurrency());
    }
}