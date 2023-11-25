<?php

namespace App\Service\DataTransferObject;

final class Fee implements FeeInterface
{
	private float $baseAmount;

	private float $amount;

	private TransactionInterface $transactionInBaseCurrency;

	public function __construct(
		private readonly TransactionInterface $originalTransaction,
		private readonly ExchangeRateInterface $exchangeRate,
		private readonly TransactionStatisticInterface $statistic,
	) {
		$this->transactionInBaseCurrency = $this->originalTransaction->convert($this->exchangeRate);
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

	public function getTransactionInBaseCurrency(): TransactionInterface
	{
		return $this->transactionInBaseCurrency;
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
