<?php

declare(strict_types=1);

namespace App\Tests\Integration\Service;

use App\Service\CommissionFeeService;
use App\Service\TransactionDataBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use DateTime;

class CommissionFeeServiceTest extends KernelTestCase
{
	private array $transactionsData;

	public function setUp(): void
	{
		$rates = [
			'base' => 'EUR',
			'date' => '2023-11-10',
			'rates' => [
				'USD' => 1.1497,
				'JPY' => 129.53,
				'EUR' => 1.0,
			],
		];

		$response = new JsonMockResponse($rates);
		$kernel = self::bootKernel(['environment' => 'test']);
		$container = $kernel->getContainer();
		$container->set(HttpClientInterface::class, new MockHttpClient($response));
		$this->transactionsData = json_decode(file_get_contents(__DIR__.'/../data/input.json'));
	}

	public function testCommissionFeeCalculation(): void
	{
		/** @var CommissionFeeService $commissionFeeService */
		$commissionFeeService = $this->getContainer()->get(CommissionFeeService::class);
		foreach ($this->transactionsData as $transactionData) {
			$transaction = (new TransactionDataBuilder())
				->setCurrency($transactionData->currency)
				->setDate(new DateTime($transactionData->date))
				->setType($transactionData->type)
				->setDirection($transactionData->direction)
				->setValue($transactionData->amount)
				->setUserId($transactionData->userId)
				->build();

			$fee = $commissionFeeService->calculateCommissionFee($transaction);
			self::assertEquals($transactionData->commission, $fee->getAmount(), sprintf('Amount: %f, calculated fee: %f, ecxpetded fee: %f', $fee->getOriginalTransaction()->getAmount(), $fee->getAmount(), $transactionData->commission));
		}
	}
}
