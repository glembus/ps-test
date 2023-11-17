<?php

namespace App\Service\FeeCalculator;

use App\Service\DataTransferObject\Fee;

abstract class AbstractFeeCalculator implements FeeCalculatorInterface
{
    public function calculateFee(Fee $fee): void
    {
        $this->calculateCommissionFee($fee);
        $this->updateUserStatistics($fee);
    }

    abstract protected function updateUserStatistics(Fee $fee): void;

    abstract protected function calculateCommissionFee(Fee $fee): void;

    protected function calculateFeeAmount(Fee $fee, float $chargeFee): float
    {
        $value = $fee->getBaseAmount() * $chargeFee;
        $roundedValue = round($value, 2, PHP_ROUND_HALF_DOWN);
        if (($value - $roundedValue) === 0.0) {
            return $roundedValue;
        }

        return $roundedValue + 0.01;
    }
}
