<?php

namespace App\Service\DataTransferObject;

class UserWeekTransactionStatistic
{
    private const WITHDRAW_ATTEMPT_LIMIT = 3;
    private const PRIVATE_FREE_WITHDRAW_LIMIT = 1000.0;

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

    public function getWithdrawAttempts(): int
    {
        return $this->withdrawAttempts;
    }

    public function getWithdrawnSum(): float
    {
        return 0.0 === $this->withdrawnSum ? self::PRIVATE_FREE_WITHDRAW_LIMIT : $this->withdrawnSum;
    }

    public function isWithdrawFeeCanBeCharged(float $withdrawSum): bool
    {
        return $this->withdrawAttempts >= 3 || ($this->withdrawnSum + $withdrawSum) > 1000.00;
    }
}
