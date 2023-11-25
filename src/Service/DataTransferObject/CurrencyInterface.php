<?php

namespace App\Service\DataTransferObject;

interface CurrencyInterface
{
	public function getAmount(): float;

	public function getCurrency(): string;
}
