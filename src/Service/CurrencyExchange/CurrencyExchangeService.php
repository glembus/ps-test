<?php

namespace App\Service\CurrencyExchange;

use App\Service\DataContract\ExchangeRateInterface;

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
