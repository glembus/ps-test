<?php

namespace App\Service\FeeCalculator;

use App\Service\DataTransferObject\FeeInterface;

abstract class AbstractFeeCalculator implements FeeCalculatorInterface
{
	public function calculateFee(FeeInterface $fee): void
	{
		$this->calculateCommissionFee($fee);
		$this->updateUserStatistics($fee);
	}

	abstract protected function updateUserStatistics(FeeInterface $fee): void;

	abstract protected function calculateCommissionFee(FeeInterface $fee): void;

	protected function calculateFeeAmount(FeeInterface $fee, float $chargeFee): float
	{
		$value = round($fee->getBaseAmount() * $chargeFee, 3);
		$roundedValue = round($value, 2, PHP_ROUND_HALF_DOWN);
		if (($value - $roundedValue) === 0.0) {
			return $roundedValue;
		}

		return $roundedValue + 0.01;
	}
}
