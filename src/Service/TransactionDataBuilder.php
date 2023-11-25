<?php

namespace App\Service;

use App\Service\DataContract\TransactionInterface;
use App\Service\DataTransferObject\Transaction;

class TransactionDataBuilder
{
	private \DateTime $date;

	private int $userId;

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

	public function setDate(\DateTime $date): self
	{
		$this->date = $date;

		return $this;
	}

	public function setDirection(string $direction): self
	{
		$this->direction = $direction;

		return $this;
	}

	public function setUserId(int $userId): self
	{
		$this->userId = $userId;

		return $this;
	}

	public function setValue(float $value): self
	{
		$this->value = $value;

		return $this;
	}

	public function build(): TransactionInterface
	{
		if (!Transaction::isTransactionTypeValid($this->type)) {
			throw new \Exception('Unsupported type exception');
		}

		return new Transaction(
			type: $this->type,
			userId: $this->userId,
			amount: $this->value,
			currency: $this->currency,
			direction: $this->direction,
			date: $this->date
		);
	}
}
