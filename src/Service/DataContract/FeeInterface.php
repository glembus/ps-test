<?php

namespace App\Service\DataContract;

interface FeeInterface extends CurrencyInterface, \Stringable
{
	public function getTransactionStatistic(): TransactionStatisticInterface;

	public function setAmount(float $amount): void;

	public function getTransactionInBaseCurrency(): TransactionInterface;

	public function getOriginalTransaction(): TransactionInterface;

	public function setBaseAmount(float $baseAmount): void;

	public function getBaseAmount(): float;

	public function getExchangeRate(): ExchangeRateInterface;
}
