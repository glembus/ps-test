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
    ) {
    }

    protected function calculateCommissionFee(Fee $fee): void
    {
        if ($fee->getOriginalTransaction()->getType() === TransactionInterface::TYPE_BUSINESS) {
            $fee->setBaseAmount($fee->getOriginalTransaction()->getAmount());
            $fee->setAmount($this->calculateFeeAmount($fee, $this->withdrawBusinessFee));

            return;
        }

        $this->calculateBaseAmountForCommission($fee);
        $fee->setAmount($this->calculateFeeAmount($fee, $this->withdrawPrivateFee));
    }

    protected function updateUserStatistics(Fee $fee): void
    {
        $fee->getUserWeekTransactionStatistic()->withdraw($fee->getTransactionInBaseCurrency()->getAmount());
    }

    private function calculateBaseAmountForCommission(Fee $fee): void
    {
        $statistic = $fee->getUserWeekTransactionStatistic();
        if (!$statistic->isWithdrawFeeCanBeCharged($fee->getTransactionInBaseCurrency()->getAmount())) {
            $fee->setBaseAmount(0.0);

            return;
        }

        if (!$statistic->isUserReachWithdrawAttemptLimit()) {
            $amount = $fee->getTransactionInBaseCurrency()->getAmount() - $statistic->getWithdrawnSum();
            if ($amount <= 0) {
                $fee->setBaseAmount(0.0);

                return;
            }

            $fee->setBaseAmount($amount * $fee->getExchangeRate()->getRate());

            return;
        }

        $fee->setBaseAmount($fee->getOriginalTransaction()->getAmount());
    }
}
