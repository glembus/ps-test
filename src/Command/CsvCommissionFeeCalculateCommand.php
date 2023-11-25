<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\CommissionFeeService;
use App\Service\DataProviderFactory;
use App\Service\DataTransferObject\DataContract\TransactionInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;

#[AsCommand(
	name: 'calculator:commission:csv',
	description: 'This command calculate commission fee for transactions provided in cvs file. CSV file must be provided as parameter',
	hidden: false
)]
final class CsvCommissionFeeCalculateCommand extends Command
{
	public function __construct(
		private readonly CommissionFeeService $commissionFeeService,
		private readonly DataProviderFactory $dataProviderFactory,
	) {
		parent::__construct();
	}

	protected function configure(): void
	{
		$this
			->addArgument('file', InputArgument::REQUIRED, 'File with transaction data.')
			->addOption('csv-separator', 's', InputOption::VALUE_OPTIONAL, 'CSV column separator. Default is comma', ',')
			->addOption('debug', 'd', InputOption::VALUE_NONE, 'Show full output data for debugging')
		;
	}

	public function execute(InputInterface $input, OutputInterface $output): int
	{
		$filePath = $input->getArgument('file');
		$separator = $input->getOption('csv-separator');
		if (!is_string($filePath) || !is_string($separator)) {
			throw new Exception('File must be string');
		}

		$dataProvider = $this->dataProviderFactory->getCsvDataProvider($filePath, $separator);
		$debugMode = (bool) $input->getOption('debug');
		/** @var TransactionInterface $transaction */
		foreach ($dataProvider->getIterator() as $transaction) {
			$fee = $this->commissionFeeService->calculateCommissionFee($transaction);
			if ($debugMode) {
				$output->write('User: '.$fee->getOriginalTransaction()->getUserId().' Transaction amount: '.$fee->getOriginalTransaction().' Trans in base: '.$fee->getTransInBaseCurrency().' Base amount: '.$fee->getBaseAmount().' fee: ');
			}

			$output->writeln((string) $fee);
		}

		return self::SUCCESS;
	}
}
