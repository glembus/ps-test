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

    protected function calculateCommissionFee(Fee $fee): void
    {
        $fee->setBaseAmount($fee->getOriginalTransaction()->getAmount());
        $fee->setAmount($this->calculateFeeAmount($fee, $this->depositFee));
    }

    protected function updateUserStatistics(Fee $fee): void
    {
        return; //Do nothing. Can be updated if need to do something with deposit flow
    }
}
