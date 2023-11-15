<?php

namespace App\Service\FeeCalculator;

use App\Service\DataTransferObject\Fee;
use App\Service\DataTransferObject\TransactionInterface;
use App\Service\DataTransferObject\UserWeekTransactionStatistic;

class DepositFeeCalculator extends AbstractFeeCalculator
{
    public function __construct(private readonly float $depositFee)
    {
    }

    public function calculateCommissionFee(
        UserWeekTransactionStatistic $statistic,
        TransactionInterface $transaction,
    ): Fee
    {
        return new Fee(
            $this->calculateFee($transaction->getValue(), $this->depositFee),
            $transaction->getCurrency()
        );
    }
}