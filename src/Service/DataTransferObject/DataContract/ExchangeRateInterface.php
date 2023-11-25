<?php

declare(strict_types=1);

namespace App\Service\DataTransferObject\DataContract;

interface ExchangeRateInterface
{
	public function getRate(): float;

	public function getCurrency(): string;

	public function getInverseExchangeRate(string $currency): self;
}
