<?php

namespace App\Service\FeeCalculator;

use App\Service\DataTransferObject\Fee;
use App\Service\DataTransferObject\TransactionInterface;
use App\Service\DataTransferObject\UserWeekTransactionStatistic;

abstract class AbstractFeeCalculator implements FeeCalculatorInterface
{
    abstract public function calculateCommissionFee(UserWeekTransactionStatistic $statistic, TransactionInterface $transaction): Fee;

    protected function calculateFee(float $value, float $chargeFee): float
    {
        $value = $value * $chargeFee;
        $roundedValue = round($value, 2, PHP_ROUND_HALF_DOWN);
        if (($value - $roundedValue) === 0.0) {
            return $roundedValue;
        }

        return $roundedValue + 0.01;
    }
}