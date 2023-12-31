<?php

declare(strict_types=1);

namespace App\Service\FeeCalculator;

interface TransactionDirectionInterface
{
	public const DIRECTION_WITHDRAW = 'withdraw';
	public const DIRECTION_DEPOSIT = 'deposit';

	public function getDirection(): string;
}
