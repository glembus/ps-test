<?php

namespace App\Service\DataContract;

interface ConvertInterface extends CurrencyInterface
{
	public function convert(ExchangeRateInterface $rate): static;
}
