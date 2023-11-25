<?php

declare(strict_types=1);

namespace App\Service\DataTransferObject\DataContract;

interface CurrencyInterface
{
	public function getAmount(): float;

	public function getCurrency(): string;
}
