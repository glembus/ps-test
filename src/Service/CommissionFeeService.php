<?php

namespace App\Service;

use App\Service\CurrencyExchange\CurrencyExchangeService;
use App\Service\DataTransferObject\Fee;
use App\Service\DataTransferObject\TransactionInterface;
use App\Service\FeeCalculator\FeeCalculatorFactory;

final class CommissionFeeService
{
    public function __construct(
        private readonly FeeCalculatorFactory $feeCalculatorFactory,
        private readonly TransactionStorageInterface $transactionStorage,
    ){
    }

    public function calculateCommissionFee(TransactionInterface $transaction): Fee
    {
        $feeCalculator = $this->feeCalculatorFactory->getFeeCalculator($transaction);
        $userTransactionStatistics = $this->transactionStorage->getUserWeekTransactionsStatistic($transaction->getUserId(), $transaction->getDate());
        $commissionFee = $feeCalculator->calculateCommissionFee($userTransactionStatistics, $transaction);
        $this->transactionStorage->updateUserWeekTransactionsStatistic($transaction->getUserId(), $userTransactionStatistics);

        return $commissionFee;
    }
}