<?php

namespace App\Service;

use App\Service\DataTransferObject\UserWeekTransactionStatistic;

final class InMemoryTransactionStorage implements TransactionStorageInterface
{
	/**
	 * @var \ArrayAccess<int, UserWeekTransactionStatistic>
	 */
	private \ArrayAccess $transactionCollection;

	private static string $currentWeek = '';

	public function __construct()
	{
		$this->clearStorage();
	}

	public function clearStorage(): void
	{
		$this->transactionCollection = new \ArrayObject();
	}

	public function getUserWeekTransactionsStatistic(int $userId, \DateTime $date): UserWeekTransactionStatistic
	{
		$this->validateStorageForDate($date->format('W o'));

		if (!$this->transactionCollection->offsetExists($userId)) {
			$this->updateUserWeekTransactionsStatistic($userId, new UserWeekTransactionStatistic());
		}

		return $this->transactionCollection->offsetGet($userId);
	}

	public function updateUserWeekTransactionsStatistic(int $userId, UserWeekTransactionStatistic $statistic): void
	{
		$this->transactionCollection->offsetSet($userId, $statistic);
	}

	private function validateStorageForDate(string $transactionWeek): void
	{
		if ($transactionWeek !== self::$currentWeek) {
			$this->clearStorage();
			self::$currentWeek = $transactionWeek;
		}
	}
}
