<?php

namespace App\Service\CurrencyExchange;

use App\Service\DataTransferObject\ExchangeRateInterface;

final class ExchangeRateCollection
{
	/** @var \ArrayIterator<string, ExchangeRateInterface> */
	private \ArrayIterator $rates;

	private readonly \DateTime $date;

	public function __construct(
		private readonly string $baseCurrency,
		string $date,
	) {
		$this->date = new \DateTime($date);

		$this->rates = new \ArrayIterator();
	}

	public function addExchangeRate(ExchangeRateInterface $rate): self
	{
		$this->rates->offsetSet($rate->getCurrency(), $rate);

		return $this;
	}

	public function getExchangeRateForCurrency(string $currency): ExchangeRateInterface
	{
		$exchangeRate = $this->rates->offsetGet($currency);
		if ($exchangeRate instanceof ExchangeRateInterface) {
			return $exchangeRate;
		}

		throw new \Exception('Invalid currency provided');
	}

	public function getDate(): \DateTime
	{
		return $this->date;
	}

	public function getBaseCurrency(): string
	{
		return $this->baseCurrency;
	}
}
