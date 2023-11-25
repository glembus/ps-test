<?php

declare(strict_types=1);

namespace App\Service\DataTransferObject;

use App\Service\DataTransferObject\DataContract\ExchangeRateInterface;
use App\Service\DataTransferObject\DataContract\FeeInterface;
use App\Service\DataTransferObject\DataContract\TransactionInterface;
use App\Service\DataTransferObject\DataContract\TransactionStatisticInterface;

final class Fee implements FeeInterface
{
	private float $baseAmount;

	private float $amount;

	private TransactionInterface $transInBaseCurrency;

	public function __construct(
		private readonly TransactionInterface $originalTransaction,
		private readonly ExchangeRateInterface $exchangeRate,
		private readonly TransactionStatisticInterface $statistic,
	) {
		$this->transInBaseCurrency = $this->originalTransaction->convert($this->exchangeRate);
	}

	public function getExchangeRate(): ExchangeRateInterface
	{
		return $this->exchangeRate;
	}

	public function getBaseAmount(): float
	{
		return $this->baseAmount;
	}

	public function setBaseAmount(float $baseAmount): void
	{
		$this->baseAmount = $baseAmount;
	}

	public function getOriginalTransaction(): TransactionInterface
	{
		return $this->originalTransaction;
	}

	public function getTransInBaseCurrency(): TransactionInterface
	{
		return $this->transInBaseCurrency;
	}

	public function getCurrency(): string
	{
		return $this->originalTransaction->getCurrency();
	}

	public function setAmount(float $amount): void
	{
		$this->amount = $amount;
	}

	public function getAmount(): float
	{
		return $this->amount;
	}

	public function getTransactionStatistic(): TransactionStatisticInterface
	{
		return $this->statistic;
	}

	public function __toString(): string
	{
		return (string) round($this->amount, 2);
	}
}
