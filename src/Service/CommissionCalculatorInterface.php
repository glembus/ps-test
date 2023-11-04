<?php

namespace App\Service\CurrencyExchange;

use App\ValueObject\TransactionInterface;

interface CommissionCalculatorInterface
{
    public function calculateCommissionFee(TransactionInterface $transaction): float;
}