<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Reader;

use League\Csv\Reader;

final class CsvReader implements ReaderInterface
{
    public function read(string $filePath): \Iterator
    {
        return Reader::createFromPath($filePath, 'r')->setHeaderOffset(0)->getIterator();
    }
}
