<?php

namespace App\Service\DataTransferObject;

class Transaction implements TransactionInterface
{
    public static $availableTypes = [self::TYPE_BUSINESS, self::TYPE_PRIVATE];

    private \DateTime $date;

    public function __construct(
        private readonly string $type,
        private readonly int $userId,
        private readonly float $value,
        private readonly string $currency,
        private readonly string $direction,
        string $date
    )
    {
        $this->date = date_create_from_format('Y-m-d', $date);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function convert(ExchangeRate $rate): static
    {
        if ($rate->getCurrency() === $this->currency) {
            return $this;
        }

        return new static(
            type: $this->type,
            userId: $this->userId,
            value: $this->value * $rate->getRate(),
            currency: $rate->getCurrency(),
            direction: $this->direction,
            date: $this->date,
        );
    }

    public function getWeek(): int
    {
        return $this->date->format('W');
    }

    public static function isTransactionTypeValid(string $transactionType): bool
    {
        return in_array($transactionType, self::$availableTypes);
    }
}