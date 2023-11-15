<?php

namespace App\Service\DataProvider;

use App\Service\DataTransferObject\TransactionInterface;
use App\Service\TransactionDataBuilder;

class CsvDataAdapter implements DataAdapterInterface
{
    public static function convertToTransaction(mixed $transactionData): TransactionInterface
    {
        if (!is_array($transactionData)) {
            throw new \Exception('Invalid data type provided. Accept array');
        }

        $transactionBuilder = new TransactionDataBuilder();
        $transactionBuilder
            ->setDate(date_create_from_format('Y-m-d', $transactionData[0]))
            ->setUserId($transactionData[1])
            ->setType($transactionData[2])
            ->setDirection($transactionData[3])
            ->setValue($transactionData[4])
            ->setCurrency($transactionData[5])
            ;

        return $transactionBuilder->build();
    }
}