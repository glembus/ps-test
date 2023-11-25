<?php

namespace App\Service\DataTransferObject;

final class ExchangeRate implements ExchangeRateInterface
{
	public function __construct(
		private float $rate,
		private string $currency,
	) {
	}

	public function getRate(): float
	{
		return $this->rate;
	}

	public function getCurrency(): string
	{
		return $this->currency;
	}

	public function getInverseExchangeRate(string $currency): self
	{
		$rate = clone $this;
		$rate->rate = 1 / $this->rate;
		$rate->currency = $currency;

		return $rate;
	}
}
