<?php

declare(strict_types=1);

namespace App\Service\CurrencyExchange;

interface ExchangeRateProviderInterface
{
	public function getExchangeRates(): ExchangeRateCollection;
}
