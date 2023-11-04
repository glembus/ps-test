<?php

namespace App\ValueObject;

abstract class Transaction implements TransactionInterface
{
    public function __construct(
        private readonly float $value,
        private readonly string $currency,
        private readonly string $clientType,
    )
    {
    }

    public function getClientType(): string
    {
        return $this->clientType;
    }

    public function isBusinessClient(): bool
    {
        return self::CLIENT_BUSiNESS === $this->clientType;
    }

    public function isPrivateClient(): bool
    {
        return self::CLIENT_PRIVATE === $this->clientType;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function convert(ExchangeRate $rate): Transaction
    {
        if ($rate->getCurrency() === $this->currency) {
            return $this;
        }

        return new static($this->value * $rate->getRate(), $rate->getCurrency());
    }

    public function __toString(): string
    {
        if (null !== $this->roundedValue) {
            $roundedValue = round($this->value, 2, PHP_ROUND_HALF_DOWN);
            if (($this->value - $roundedValue) == 0) {
                return $roundedValue;
            }

            return $roundedValue + 0.01;
        }

        return $this->roundedValue;
    }
}