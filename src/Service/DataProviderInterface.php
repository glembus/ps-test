<?php

namespace App\Service;

use App\Service\DataTransferObject\TransactionInterface;

interface DataProviderInterface
{
    /**
     * @return \Traversable<TransactionInterface>
     */
    public function getIterator(): \Traversable;
}
