<?php

declare(strict_types=1);

namespace App\Service\FeeCalculator;

use App\Service\DataTransferObject\DataContract\FeeInterface;

interface FeeCalculatorInterface
{
	public function calculateFee(FeeInterface $fee): void;
}
