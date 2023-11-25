<?php

namespace App\Service\DataContract;

interface TransactionStatisticInterface
{
	public const WITHDRAW_ATTEMPT_LIMIT = 3;
	public const PRIVATE_FREE_WITHDRAW_LIMIT = 1000.0;

	public function withdraw(float $value): self;

	public function isUserReachWithdrawAttemptLimit(): bool;

	public function getFreeWithdrawnAmountLeft(): float;

	public function isWithdrawFeeCanBeCharged(float $withdrawSum): bool;
}
