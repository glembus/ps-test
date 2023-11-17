<?php

namespace App\Service\FeeCalculator;

use App\Service\CurrencyExchange\CurrencyExchangeService;

class FeeCalculatorFactory
{
    public function __construct(
        private readonly CurrencyExchangeService $exchangeService,
        private readonly float $depositFee,
        private readonly float $withdrawPrivateFee,
        private readonly float $withdrawBusinessFee
    ) {
    }

    public function getFeeCalculator(TransactionDirectionInterface $transactionType): FeeCalculatorInterface
    {
        return match ($transactionType->getDirection()) {
            TransactionDirectionInterface::DIRECTION_DEPOSIT => new DepositFeeCalculator($this->depositFee),
            TransactionDirectionInterface::DIRECTION_WITHDRAW => new WithdrawFeeCalculator($this->exchangeService, $this->withdrawPrivateFee, $this->withdrawBusinessFee),
        };
    }
}
