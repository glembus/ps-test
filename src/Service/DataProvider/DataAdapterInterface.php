<?php

namespace App\Service\DataProvider;

use App\Service\DataTransferObject\TransactionInterface;

interface DataAdapterInterface
{
    public static function convertToTransaction(mixed $transactionData): TransactionInterface;
}
