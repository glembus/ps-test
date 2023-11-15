<?php

namespace App\Command;

use App\Service\CommissionFeeService;
use App\Service\DataProviderFactory;
use App\Service\DataTransferObject\TransactionInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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

    protected function configure()
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'File with transaction data.')
            ->addOption('csv-separator', 's', InputOption::VALUE_OPTIONAL, 'CSV column separator. Default is comma', ',')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('file');
        $dataProvider = $this->dataProviderFactory->getCsvDataProvider($filePath, $input->getOption('csv-separator'));
        /** @var TransactionInterface $transaction */
        foreach ($dataProvider->getIterator() as $transaction) {
            $fee = $this->commissionFeeService->calculateCommissionFee($transaction);
            $output->writeln((string) $fee);
        }

        return self::SUCCESS;
    }
}