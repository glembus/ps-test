<?php

declare(strict_types=1);

namespace App\Service\DataProvider;

use App\Service\DataTransferObject\DataContract\TransactionInterface;
use App\Service\TransactionDataBuilder;
use Exception;
use DateTime;

final class CsvDataAdapter implements DataAdapterInterface
{
	public static function convertToTransaction(mixed $transactionData): TransactionInterface
	{
		if (!is_array($transactionData)) {
			throw new Exception('Invalid data type provided. Accept array');
		}

		$transactionBuilder = new TransactionDataBuilder();
		$transactionBuilder
			->setDate(new DateTime($transactionData[0]))
			->setUserId($transactionData[1])
			->setType($transactionData[2])
			->setDirection($transactionData[3])
			->setValue($transactionData[4])
			->setCurrency($transactionData[5])
		;

		return $transactionBuilder->build();
	}
}
