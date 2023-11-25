<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\DataTransferObject\DataContract\TransactionStatisticInterface;
use App\Service\DataTransferObject\UserWeekTransactionStatistic;
use ArrayObject;
use DateTime;
use Exception;
use ArrayAccess;

final class InMemoryTransactionStorage implements TransactionStorageInterface
{
	/**
	 * @var ArrayAccess<int, TransactionStatisticInterface>
	 */
	private ArrayAccess $statistics;

	private static string $currentWeek = '';

	public function __construct()
	{
		$this->clearStorage();
	}

	public function clearStorage(): void
	{
		$this->statistics = new ArrayObject();
	}

	public function getUserWeekTransactionsStatistic(int $userId, DateTime $date): TransactionStatisticInterface
	{
		$this->validateStorageForDate($date->format('W o'));

		if (!$this->statistics->offsetExists($userId)) {
			$this->updateUserWeekTransactionsStatistic($userId, new UserWeekTransactionStatistic());
		}

		$statistic = $this->statistics->offsetGet($userId);
		if ($statistic instanceof TransactionStatisticInterface) {
			return $statistic;
		}

		return throw new Exception('Unsupported data type received from statistic storage');
	}

	public function updateUserWeekTransactionsStatistic(int $userId, TransactionStatisticInterface $statistic): void
	{
		$this->statistics->offsetSet($userId, $statistic);
	}

	private function validateStorageForDate(string $transactionWeek): void
	{
		if ($transactionWeek !== self::$currentWeek) {
			$this->clearStorage();
			self::$currentWeek = $transactionWeek;
		}
	}
}
