<?php

namespace App\Service;

use App\Service\DataTransferObject\TransactionInterface;
use App\Service\DataTransferObject\UserWeekTransactionStatistic;
use ArrayAccess;

final class InMemoryTransactionStorage implements TransactionStorageInterface
{
    /**
     * @var ArrayAccess<string, TransactionInterface>
     */
    private ArrayAccess $transactionCollection;

    private static int $currentWeek = 0;

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
        $this->validateStorageForDate($date->format('W'));

        if (!$this->transactionCollection->offsetExists($userId)) {
            $this->updateUserWeekTransactionsStatistic($userId, new UserWeekTransactionStatistic());
        }

        return $this->transactionCollection->offsetGet($userId);
    }

    public function updateUserWeekTransactionsStatistic(int $userId, UserWeekTransactionStatistic $statistic): void
    {
        $this->transactionCollection->offsetSet($userId, $statistic);
    }

    private function validateStorageForDate(int $transactionWeek): void
    {
        if ($transactionWeek !== self::$currentWeek) {
            $this->clearStorage();
            self::$currentWeek = $transactionWeek;
        }
    }
}