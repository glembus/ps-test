<?php

declare(strict_types=1);

namespace App\Service\DataTransferObject\DataContract;

interface FeeInterface extends CurrencyInterface, \Stringable
{
	public function getTransactionStatistic(): TransactionStatisticInterface;

	public function setAmount(float $amount): void;

	public function getTransInBaseCurrency(): TransactionInterface;

	public function getOriginalTransaction(): TransactionInterface;

	public function setBaseAmount(float $baseAmount): void;

	public function getBaseAmount(): float;

	public function getExchangeRate(): ExchangeRateInterface;
}
