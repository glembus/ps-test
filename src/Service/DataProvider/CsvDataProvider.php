<?php

namespace App\Service\DataProvider;

use App\Exception\UnreachableResourceException;
use App\Service\DataProviderInterface;
use App\Service\DataTransferObject\TransactionInterface;
use Psr\Log\LoggerInterface;
use Traversable;

class CsvDataProvider implements DataProviderInterface
{
    private \SplFileObject $file;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly string $filePath,
        private readonly string $columnSeparator = ','
    ) {
    }

    /**
     * @return Traversable<TransactionInterface>
     * @throws UnreachableResourceException
     */
    public function getIterator(): Traversable
    {
        $this->prepareFile();
        foreach ($this->file as $row) {
            try {
                yield CsvDataAdapter::convertToTransaction($row);
            } catch (\Exception $e) {
                $this->logger->error('transaction_build_fail', [
                    'sErrorMessage' => $e->getMessage(),
                    'sData' => print_r($row, true),
                ]);
            }
        }
    }

    private function prepareFile(): void
    {
        $fileInfo = new \SplFileInfo($this->filePath);
        if ($fileInfo->isDir()) {
            throw new UnreachableResourceException($this->filePath);
        }

        $this->removeBomPartFromFile($this->filePath);
        $this->file = $fileInfo->openFile('r');
        $this->file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::READ_AHEAD);
        $this->file->setCsvControl($this->columnSeparator);
    }

    private function removeBomPartFromFile(string $filePath): void
    {
        $content = file_get_contents($filePath);
        if (false !== $content && str_starts_with($content, "\xEF\xBB\xBF")) {
            $content = substr($content, 3);
            file_put_contents($filePath, $content);
        }
    }
}
