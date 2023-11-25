<?php

namespace App\Service;

use App\Service\CurrencyExchange\CurrencyExchangeService;
use App\Service\DataTransferObject\Fee;
use App\Service\DataTransferObject\TransactionInterface;
use App\Service\FeeCalculator\FeeCalculatorFactory;

final class CommissionFeeService
{
	public function __construct(
		private readonly CurrencyExchangeService $exchangeService,
		private readonly FeeCalculatorFactory $feeCalculatorFactory,
		private readonly TransactionStorageInterface $transactionStorage,
	) {
	}

	public function calculateCommissionFee(TransactionInterface $transaction): Fee
	{
		$feeCalculator = $this->feeCalculatorFactory->getFeeCalculator($transaction);
		$statistics = $this->transactionStorage->getUserWeekTransactionsStatistic($transaction->getUserId(), $transaction->getDate());
		$baseRate = $this->exchangeService->getExchangeRate($transaction->getCurrency())->getInverseExchangeRate('EUR');
		$fee = new Fee($transaction, $baseRate, $statistics);
		$feeCalculator->calculateFee($fee);
		$this->transactionStorage->updateUserWeekTransactionsStatistic($transaction->getUserId(), $fee->getTransactionStatistic());

		return $fee;
	}
}
