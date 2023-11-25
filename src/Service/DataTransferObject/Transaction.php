<?php

declare(strict_types=1);

namespace App\Service\DataTransferObject;

use App\Service\DataTransferObject\DataContract\ExchangeRateInterface;
use App\Service\DataTransferObject\DataContract\TransactionInterface;
use DateTime;

final class Transaction implements TransactionInterface
{
	/** @var array<string> */
	public static array $availableTypes = [self::TYPE_BUSINESS, self::TYPE_PRIVATE];

	public function __construct(
		private readonly string $type,
		private readonly int $userId,
		private readonly float $amount,
		private readonly string $currency,
		private readonly string $direction,
		private readonly DateTime $date,
	) {
	}

	public function getUserId(): int
	{
		return $this->userId;
	}

	public function getDate(): DateTime
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

	public function getAmount(): float
	{
		return $this->amount;
	}

	public function getDirection(): string
	{
		return $this->direction;
	}

	public function convert(ExchangeRateInterface $rate): static
	{
		return new self(
			type: $this->type,
			userId: $this->userId,
			amount: $this->amount * $rate->getRate(),
			currency: $rate->getCurrency(),
			direction: $this->direction,
			date: $this->date,
		);
	}

	public static function isTransactionTypeValid(string $transactionType): bool
	{
		return in_array($transactionType, self::$availableTypes);
	}

	public function __toString(): string
	{
		return (string) round($this->amount, 2);
	}
}
