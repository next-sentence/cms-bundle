<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Uploader;

use Lwc\CmsBundle\Entity\MediaInterface;

interface MediaUploaderInterface
{
    public function upload(MediaInterface $media, string $pathPrefix): void;

    public function remove(string $path): bool;
}
