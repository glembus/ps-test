<?php

declare(strict_types=1);

namespace App\Service\DataTransferObject;

use App\Service\DataTransferObject\DataContract\ExchangeRateInterface;

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
