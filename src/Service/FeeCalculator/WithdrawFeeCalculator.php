<?php

namespace App\Service\FeeCalculator;

use App\Service\CurrencyExchange\CurrencyExchangeService;
use App\Service\DataTransferObject\Fee;
use App\Service\DataTransferObject\TransactionInterface;
use App\Service\DataTransferObject\UserWeekTransactionStatistic;

class WithdrawFeeCalculator extends AbstractFeeCalculator
{
    public function __construct(
        protected readonly CurrencyExchangeService $exchangeService,
        private readonly float $withdrawPrivateFee,
        private readonly float $withdrawBusinessFee
    ){
    }

    public function calculateCommissionFee(UserWeekTransactionStatistic $statistic, TransactionInterface $transaction): Fee
    {
        if ($transaction->getType() === TransactionInterface::TYPE_BUSINESS) {
            return new Fee(
                $this->calculateFee($transaction->getValue(), $this->withdrawBusinessFee),
                $transaction->getCurrency()
            );
        }

        $fee = 0;
        $convertedTransaction = $this->exchangeService->convertToCurrency($transaction, 'EUR');
        if ($statistic->isWithdrawFeeCanBeCharged($convertedTransaction->getValue())) {
            $fee = $this->calculateFee($transaction->getValue(), $this->withdrawPrivateFee);
        }

        $statistic->withdraw($convertedTransaction->getValue());

        return new Fee($fee, $transaction->getCurrency());
    }
}