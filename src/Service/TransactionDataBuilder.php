<?php

namespace App\Service;

use App\Service\DataTransferObject\Transaction;
use App\Service\DataTransferObject\TransactionInterface;

class TransactionDataBuilder
{
    private ?\DateTimeImmutable $date;

    private string $userId = '';

    private string $direction;

    private float $value;

    private string $currency;

    private string $type;

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function setDirection(string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function build(): TransactionInterface
    {
        if (!Transaction::isTransactionTypeValid($this->type)) {
            throw new \Exception('Unsupported type exception');
        }

        return new Transaction(
            type: $this->type,
            userId: $this->userId,
            value: $this->value,
            currency: $this->currency,
            direction: $this->direction,
            date: $this->date
        );
    }
}