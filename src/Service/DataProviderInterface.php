<?php

namespace App\Service;

use App\Service\DataContract\TransactionInterface;

interface DataProviderInterface
{
	/**
	 * @return \Traversable<TransactionInterface>
	 */
	public function getIterator(): \Traversable;
}
