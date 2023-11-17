<?php

namespace App\Service\DataTransferObject;

use App\Service\FeeCalculator\TransactionDirectionInterface;

interface TransactionInterface extends TransactionDirectionInterface, ConvertInterface, \Stringable
{
    public const TYPE_BUSINESS = 'business';
    public const TYPE_PRIVATE = 'private';

    public function getWeek(): int;

    public function getUserId(): int;

    public function getDate(): \DateTime;

    public function getType(): string;
}
