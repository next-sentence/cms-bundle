<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Command;

use Lwc\CmsBundle\Processor\ImportProcessorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportFromCsvCommand extends Command
{
    /** @var ImportProcessorInterface */
    private $importProcessor;

    public function __construct(ImportProcessorInterface $importProcessor)
    {
        parent::__construct();

        $this->importProcessor = $importProcessor;
    }

    protected function configure(): void
    {
        $this
            ->setName('Lwc:import:csv')
            ->setDescription('Imports a resource')
            ->setHelp('This command allows you to import resources from CSV. It takes file path and resource name as parameter.')
            ->addArgument('resource', InputArgument::REQUIRED, 'Importer resource name.')
            ->addArgument('file', InputArgument::REQUIRED, 'CSV file path.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $resourceName = $input->getArgument('resource');
        $file = $input->getArgument('file');

        $this->importProcessor->process($resourceName, $file);
    }
}
