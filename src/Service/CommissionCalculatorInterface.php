<?php

namespace App\Service;

use App\ValueObject\TransactionInterface;

interface CommissionCalculatorInterface
{
    public function calculateCommissionFee(TransactionInterface $transaction): float;
}