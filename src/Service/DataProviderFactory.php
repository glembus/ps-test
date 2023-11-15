<?php

namespace App\Service;

use App\Service\DataProvider\CsvDataProvider;
use Psr\Log\LoggerInterface;

class DataProviderFactory
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function getCsvDataProvider(string $filePath, string $columnSeparator = ','): DataProviderInterface
    {
        return new CsvDataProvider($this->logger, $filePath, $columnSeparator);
    }
}