<?php

declare(strict_types=1);

namespace App\Service\DataTransferObject;

use App\Service\DataTransferObject\DataContract\TransactionStatisticInterface;

class UserWeekTransactionStatistic implements TransactionStatisticInterface
{
	private float $withdrawnSum = 0.0;

	private int $withdrawAttempts = 0;

	public function withdraw(float $value): self
	{
		$this->withdrawnSum += $value;
		++$this->withdrawAttempts;

		return $this;
	}

	public function isUserReachWithdrawAttemptLimit(): bool
	{
		return $this->withdrawAttempts >= self::WITHDRAW_ATTEMPT_LIMIT;
	}

	public function getFreeWithdrawnAmountLeft(): float
	{
		if ($this->withdrawAttempts >= 3) {
			return 0.0;
		}
		$limitLeft = self::PRIVATE_FREE_WITHDRAW_LIMIT - $this->withdrawnSum;
		if ($limitLeft < 0) {
			return 0.0;
		}

		return $limitLeft;
	}

	public function isWithdrawFeeCanBeCharged(float $withdrawSum): bool
	{
		return $this->withdrawAttempts >= 3 || ($this->withdrawnSum + $withdrawSum) > 1000.00;
	}
}
