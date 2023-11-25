<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\DataTransferObject\DataContract\TransactionStatisticInterface;
use DateTime;

interface TransactionStorageInterface
{
	public function getUserWeekTransactionsStatistic(int $userId, DateTime $date): TransactionStatisticInterface;

	public function updateUserWeekTransactionsStatistic(int $userId, TransactionStatisticInterface $statistic): void;
}
