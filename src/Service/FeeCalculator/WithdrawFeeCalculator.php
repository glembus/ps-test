<?php

declare(strict_types=1);

namespace App\Service\FeeCalculator;

use App\Service\DataTransferObject\DataContract\FeeInterface;
use App\Service\DataTransferObject\DataContract\TransactionInterface;

class WithdrawFeeCalculator extends AbstractFeeCalculator
{
	public function __construct(
		private readonly float $withdrawPrivateFee,
		private readonly float $withdrawBusinessFee
	) {
	}

	protected function calculateCommissionFee(FeeInterface $fee): void
	{
		if (TransactionInterface::TYPE_BUSINESS === $fee->getOriginalTransaction()->getType()) {
			$fee->setBaseAmount($fee->getOriginalTransaction()->getAmount());
			$fee->setAmount($this->calculateFeeAmount($fee, $this->withdrawBusinessFee));

			return;
		}

		$this->calculateBaseAmountForCommission($fee);
		$fee->setAmount($this->calculateFeeAmount($fee, $this->withdrawPrivateFee));
	}

	protected function updateUserStatistics(FeeInterface $fee): void
	{
		$fee->getTransactionStatistic()->withdraw($fee->getTransInBaseCurrency()->getAmount());
	}

	private function calculateBaseAmountForCommission(FeeInterface $fee): void
	{
		$statistic = $fee->getTransactionStatistic();
		if (!$statistic->isWithdrawFeeCanBeCharged($fee->getTransInBaseCurrency()->getAmount())) {
			$fee->setBaseAmount(0.0);

			return;
		}

		$freeWithdrawAmount = $statistic->getFreeWithdrawnAmountLeft();
		$fee->setBaseAmount(abs($fee->getTransInBaseCurrency()->getAmount() - $freeWithdrawAmount) * $fee->getExchangeRate()->getInverseExchangeRate($fee->getOriginalTransaction()->getCurrency())->getRate());
	}
}
