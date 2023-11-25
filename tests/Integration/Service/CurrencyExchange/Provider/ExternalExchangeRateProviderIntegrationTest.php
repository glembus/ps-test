<?php

namespace App\Tests\Integration\Service\CurrencyExchange\Provider;

use App\Service\CurrencyExchange\Provider\ExternalExchangeRateProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExternalExchangeRateProviderIntegrationTest extends KernelTestCase
{
	public function testItWithDefaultExchangeRates()
	{
		self::bootKernel();

		$rateProviderService = self::$kernel->getContainer()->get(ExternalExchangeRateProvider::class);
		//        $rateProviderService->
	}
}
