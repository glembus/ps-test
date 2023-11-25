<?php

namespace App\Service\FeeCalculator;

use App\Service\DataTransferObject\FeeInterface;

interface FeeCalculatorInterface
{
	public function calculateFee(FeeInterface $fee): void;
}
