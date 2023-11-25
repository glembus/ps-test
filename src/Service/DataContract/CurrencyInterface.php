<?php

namespace App\Service\DataContract;

interface CurrencyInterface
{
	public function getAmount(): float;

	public function getCurrency(): string;
}
