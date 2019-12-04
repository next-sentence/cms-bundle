<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Processor;

interface ImportProcessorInterface
{
    public function process(string $resourceName, string $filePath): void;
}
