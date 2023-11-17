<?php

namespace App\Service\DataTransferObject;

interface ConvertInterface extends CurrencyInterface
{
    public function convert(ExchangeRate $rate): static;
}
