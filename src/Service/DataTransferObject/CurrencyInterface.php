<?php

namespace App\Service\DataTransferObject;

interface CurrencyInterface
{
    public function getValue(): float;

    public function getCurrency(): string;
}