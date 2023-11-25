<?php

namespace App\Service;

use App\Service\DataContract\TransactionStatisticInterface;
use App\Service\DataTransferObject\UserWeekTransactionStatistic;

final class InMemoryTransactionStorage implements TransactionStorageInterface
{
	/**
	 * @var \ArrayAccess<int, TransactionStatisticInterface>
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

	public function getUserWeekTransactionsStatistic(int $userId, \DateTime $date): TransactionStatisticInterface
	{
		$this->validateStorageForDate($date->format('W o'));

		if (!$this->transactionCollection->offsetExists($userId)) {
			$this->updateUserWeekTransactionsStatistic($userId, new UserWeekTransactionStatistic());
		}

        $statistic = $this->transactionCollection->offsetGet($userId);
        if ($statistic instanceof TransactionStatisticInterface) {
            return $statistic;
        }

		return throw new \Exception('Unsupported data type received from statistic storage');
	}

	public function updateUserWeekTransactionsStatistic(int $userId, TransactionStatisticInterface $statistic): void
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
