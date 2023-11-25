<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\DataTransferObject\DataContract\TransactionInterface;
use Traversable;

interface DataProviderInterface
{
	/**
	 * @return Traversable<TransactionInterface>
	 */
	public function getIterator(): Traversable;
}
