<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Exception;

final class ImportFailedException extends \RuntimeException
{
    public function __construct(string $message, int $index)
    {
        parent::__construct(sprintf('Import failed at index %d. Exception message: %s', $index, $message));
    }
}
