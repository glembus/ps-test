<?php

namespace App\ValueObject;

interface TransactionInterface
{
    public const CLIENT_PRIVATE = 'private';
    public const CLIENT_BUSiNESS = 'business';

    public function isBusinessClient(): bool;

    public function isPrivateClient(): bool;

    public function convert(ExchangeRate $rate): TransactionInterface;
}