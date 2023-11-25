<?php

namespace App\Service\FeeCalculator;

class FeeCalculatorFactory
{
	public function __construct(
		private readonly float $depositFee,
		private readonly float $withdrawPrivateFee,
		private readonly float $withdrawBusinessFee
	) {
	}

	public function getFeeCalculator(TransactionDirectionInterface $transactionType): FeeCalculatorInterface
	{
		return match ($transactionType->getDirection()) {
			TransactionDirectionInterface::DIRECTION_DEPOSIT => new DepositFeeCalculator($this->depositFee),
			TransactionDirectionInterface::DIRECTION_WITHDRAW => new WithdrawFeeCalculator($this->withdrawPrivateFee, $this->withdrawBusinessFee),
		};
	}
}
