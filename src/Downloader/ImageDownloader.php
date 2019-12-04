<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Downloader;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

final class ImageDownloader implements ImageDownloaderInterface
{
    /** @var Filesystem */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function download(string $url): File
    {
        $pathInfo = pathinfo($url);
        $extension = $pathInfo['extension'];
        $path = sys_get_temp_dir() . md5(random_bytes(10)) . '.' . $extension;

        $this->filesystem->dumpFile($path, file_get_contents($url));

        return new File($path);
    }
}
