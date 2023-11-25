<?php

namespace App\Service\DataProvider;

use App\Exception\UnreachableResourceException;
use App\Service\DataContract\TransactionInterface;
use App\Service\DataProviderInterface;
use Psr\Log\LoggerInterface;

class CsvDataProvider implements DataProviderInterface
{
	private \SplFileObject $file;

	public function __construct(
		private readonly LoggerInterface $logger,
		private readonly string $projectDir,
		private readonly string $filePath,
		private readonly string $columnSeparator = ',',
	) {
	}

	/**
	 * @return \Traversable<TransactionInterface>
	 *
	 * @throws UnreachableResourceException
	 */
	public function getIterator(): \Traversable
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
		$this->file = $this->loadFile()->openFile('r');
		$this->file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::READ_AHEAD);
		$this->file->setCsvControl($this->columnSeparator);
	}

	private function loadFile(): \SplFileInfo
	{
		$fileInfo = new \SplFileInfo($this->filePath);
		if (!$fileInfo->isDir() && $fileInfo->isFile()) {
			$this->removeBomPartFromFile($this->filePath);

			return $fileInfo;
		}

		$internalFilePath = $this->projectDir.DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$this->filePath;
		$fileInfo = new \SplFileInfo($internalFilePath);
		if (!$fileInfo->isDir() && $fileInfo->isFile()) {
			$this->removeBomPartFromFile($internalFilePath);

			return $fileInfo;
		}

		throw new UnreachableResourceException($this->filePath);
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
