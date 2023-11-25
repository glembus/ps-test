<?php

declare(strict_types=1);

namespace App\Service\DataTransferObject\DataContract;

interface ConvertInterface extends CurrencyInterface
{
	public function convert(ExchangeRateInterface $rate): static;
}
