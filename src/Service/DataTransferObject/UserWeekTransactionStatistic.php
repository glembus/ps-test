<?php

namespace App\Service\DataTransferObject;

class UserWeekTransactionStatistic
{
    private float $withdrawnSum = 0.0;

    private int $withdrawAttempts = 0;

    public function withdraw(float $value): self
    {
        $this->withdrawnSum += $value;
        ++$this->withdrawAttempts;

        return $this;
    }

    public function isWithdrawFeeCanBeCharged(float $withdrawSum): bool
    {
        return $this->withdrawAttempts >= 3 || ($this->withdrawnSum + $withdrawSum) > 1000.00;
    }
}