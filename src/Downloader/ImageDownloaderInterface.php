<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Downloader;

use Symfony\Component\HttpFoundation\File\File;

interface ImageDownloaderInterface
{
    public function download(string $url): File;
}
