<?php

namespace App\Service\FeeCalculator;

use App\Service\DataContract\FeeInterface;

interface FeeCalculatorInterface
{
	public function calculateFee(FeeInterface $fee): void;
}
