<?php

namespace App\Service\FeeCalculator;

use App\Service\DataTransferObject\FeeInterface;

class DepositFeeCalculator extends AbstractFeeCalculator
{
	public function __construct(private readonly float $depositFee)
	{
	}

	protected function calculateCommissionFee(FeeInterface $fee): void
	{
		$fee->setBaseAmount($fee->getOriginalTransaction()->getAmount());
		$fee->setAmount($this->calculateFeeAmount($fee, $this->depositFee));
	}

	protected function updateUserStatistics(FeeInterface $fee): void
	{
		return; // Do nothing. Can be updated if need to do something with deposit flow
	}
}
