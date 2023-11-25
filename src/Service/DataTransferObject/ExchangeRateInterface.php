<?php

namespace App\Service\DataTransferObject;

interface ExchangeRateInterface
{
	public function getRate(): float;

	public function getCurrency(): string;

	public function getInverseExchangeRate(string $currency): self;
}
