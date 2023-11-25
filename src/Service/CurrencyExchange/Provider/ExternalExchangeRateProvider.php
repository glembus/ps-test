<?php

declare(strict_types=1);

namespace App\Service\CurrencyExchange\Provider;

use App\Service\CurrencyExchange\ExchangeRateCollection;
use App\Service\CurrencyExchange\ExchangeRateProviderInterface;
use App\Service\DataTransferObject\ExchangeRate;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ExternalExchangeRateProvider implements ExchangeRateProviderInterface
{
	private ExchangeRateCollection $rates;

	private bool $rateLoaded = false;

	public function __construct(
		private readonly HttpClientInterface $httpClient,
		private readonly string $serviceUrl
	) {
	}

	public function getExchangeRates(): ExchangeRateCollection
	{
		$this->loadRates();

		return $this->rates;
	}

	private function loadRates(): void
	{
		if (!$this->rateLoaded) {
			$response = $this->httpClient->request('GET', $this->serviceUrl)->toArray();
			$this->rates = new ExchangeRateCollection($response['base'], $response['date']);
			foreach ($response['rates'] as $currency => $rate) {
				$this->rates->addExchangeRate(new ExchangeRate($rate, $currency));
			}

			$this->rateLoaded = true;
		}
	}
}
