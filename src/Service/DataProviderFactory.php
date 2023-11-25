<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\DataProvider\CsvDataProvider;
use Psr\Log\LoggerInterface;

class DataProviderFactory
{
	public function __construct(private readonly LoggerInterface $logger, private readonly string $projectDir)
	{
	}

	public function getCsvDataProvider(string $filePath, string $columnSeparator = ','): DataProviderInterface
	{
		return new CsvDataProvider($this->logger, $this->projectDir, $filePath, $columnSeparator);
	}
}
