<?php

declare(strict_types=1);

namespace App\Tests\Integration\Service\CurrencyExchange\Provider;

use App\Service\CurrencyExchange\Provider\ExternalExchangeRateProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExternalExchangeRateProviderIntegrationTest extends KernelTestCase
{
	public function testItWithDefaultExchangeRates(): void
	{
		self::bootKernel();

		$rateProviderService = self::$kernel->getContainer()->get(ExternalExchangeRateProvider::class);
		//        $rateProviderService->
	}
}
