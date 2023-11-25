<?php

declare(strict_types=1);

namespace App\Service\CurrencyExchange;

use App\Service\DataTransferObject\DataContract\ExchangeRateInterface;

class CurrencyExchangeService
{
	public function __construct(private readonly ExchangeRateProviderInterface $provider)
	{
	}

	public function getExchangeRate(string $transactionCurrency): ExchangeRateInterface
	{
		return $this->provider->getExchangeRates()->getExchangeRateForCurrency($transactionCurrency);
	}
}
