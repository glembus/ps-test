<?php

namespace App\Service\DataProvider;

use App\Service\DataContract\TransactionInterface;

interface DataAdapterInterface
{
	public static function convertToTransaction(mixed $transactionData): TransactionInterface;
}
