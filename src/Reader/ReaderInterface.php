<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Reader;

interface ReaderInterface
{
    public function read(string $filePath): \Iterator;
}
