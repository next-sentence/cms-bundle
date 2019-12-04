<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Importer;

interface ImporterChainInterface
{
    public function addImporter(ImporterInterface $importer): void;

    public function getImporterForResource(string $resourceCode): ImporterInterface;
}
