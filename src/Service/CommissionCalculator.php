<?php

namespace App\Service;

use App\Service\CurrencyExchange\CurrencyExchangeService;
use App\ValueObject\TransactionInterface;

final class CommissionCalculator
{
    public function __construct(private readonly CurrencyExchangeService $exchangeService)
    {
    }

    public function calculateCommissionFee(TransactionInterface $transaction): float
    {

    }
}