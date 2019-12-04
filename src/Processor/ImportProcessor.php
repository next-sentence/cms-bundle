<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Processor;

use Lwc\CmsBundle\Exception\ImportFailedException;
use Lwc\CmsBundle\Importer\ImporterChainInterface;
use Lwc\CmsBundle\Reader\ReaderInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ImportProcessor implements ImportProcessorInterface
{
    /** @var ImporterChainInterface */
    private $importerChain;

    /** @var ReaderInterface */
    private $reader;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ImporterChainInterface $importerChain,
        ReaderInterface $reader,
        EntityManagerInterface $entityManager
    ) {
        $this->importerChain = $importerChain;
        $this->reader = $reader;
        $this->entityManager = $entityManager;
    }

    public function process(string $resourceCode, string $filePath): void
    {
        $importer = $this->importerChain->getImporterForResource($resourceCode);
        $data = $this->reader->read($filePath);

        foreach ($data as $index => $row) {
            try {
                $importer->import($row);
            } catch (\Exception $exception) {
                throw new ImportFailedException($exception->getMessage(), ++$index);
            }

            $this->entityManager->clear();
        }

        $importer->cleanup();
    }
}
