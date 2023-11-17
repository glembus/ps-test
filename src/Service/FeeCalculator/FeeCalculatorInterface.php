<?php

namespace App\Service\FeeCalculator;

use App\Service\DataTransferObject\Fee;
use App\Service\DataTransferObject\TransactionInterface;
use App\Service\DataTransferObject\UserWeekTransactionStatistic;

interface FeeCalculatorInterface
{
    public function calculateFee(Fee $fee): void;
}
