<?php

namespace App\Service;

use App\Service\DataTransferObject\UserWeekTransactionStatistic;

interface TransactionStorageInterface
{
	public function getUserWeekTransactionsStatistic(int $userId, \DateTime $date): UserWeekTransactionStatistic;

	public function updateUserWeekTransactionsStatistic(int $userId, UserWeekTransactionStatistic $statistic): void;
}
