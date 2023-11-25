<?php

namespace App\Service;

use App\Service\DataContract\TransactionStatisticInterface;

interface TransactionStorageInterface
{
	public function getUserWeekTransactionsStatistic(int $userId, \DateTime $date): TransactionStatisticInterface;

	public function updateUserWeekTransactionsStatistic(int $userId, TransactionStatisticInterface $statistic): void;
}
