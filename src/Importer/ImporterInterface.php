<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Importer;

interface ImporterInterface
{
    public function import(array $row): void;

    public function getResourceCode(): string;

    public function cleanup(): void;
}
