<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Uploader;

use Lwc\CmsBundle\Entity\ImageInterface;

interface ImageUploaderInterface
{
    public function upload(ImageInterface $media): void;

    public function remove(string $path): bool;
}
