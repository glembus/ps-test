<?php

declare(strict_types=1);

namespace App\Service\DataProvider;

use App\Service\DataTransferObject\DataContract\TransactionInterface;

interface DataAdapterInterface
{
	public static function convertToTransaction(mixed $transactionData): TransactionInterface;
}
