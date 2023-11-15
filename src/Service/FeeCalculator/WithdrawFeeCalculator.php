<?php

namespace App\Service\FeeCalculator;

use App\Service\CurrencyExchange\CurrencyExchangeService;
use App\Service\DataTransferObject\CommissionBaseAmount;
use App\Service\DataTransferObject\ConvertInterface;
use App\Service\DataTransferObject\Fee;
use App\Service\DataTransferObject\TransactionInterface;
use App\Service\DataTransferObject\UserWeekTransactionStatistic;

class WithdrawFeeCalculator extends AbstractFeeCalculator
{
    private const PRIVATE_FREE_WITHDRAW_LIMIT = 1000.0;

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

        $convertedTransaction = $this->exchangeService->convertToCurrency($transaction, 'EUR');
        $baseAmount = $this->getBaseAmountForCommission($statistic, $convertedTransaction);

        return new Fee(
            $this->exchangeService->convertToCurrency($baseAmount, $transaction->getCurrency())->getValue(),
            $transaction->getCurrency()
        );

    }

    private function getBaseAmountForCommission(UserWeekTransactionStatistic $statistic, ConvertInterface $transaction): CommissionBaseAmount
    {
        if (!$statistic->isWithdrawFeeCanBeCharged($transaction->getValue())) {
            return new CommissionBaseAmount(0.0, $transaction->getCurrency());
        }

        if (!$statistic->isUserReachWithdrawAttemptLimit()) {
            $amount = $transaction->getValue() - $statistic->getWithdrawnSum();

            return new CommissionBaseAmount($amount < 0 ? 0.0 : $amount, $transaction->getCurrency());
        }

        return new CommissionBaseAmount($transaction->getValue(), $transaction->getCurrency());
    }
}