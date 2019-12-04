<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Entity\MediaInterface;

final class MediaTypeResolver implements MediaTypeResolverInterface
{
    public function resolveType(string $mimeType): string
    {
        if (preg_match('/^(image)\/\w{0,}$/', $mimeType)) {
            return MediaInterface::IMAGE_TYPE;
        }

        if (preg_match('/^(video)\/\w{0,}$/', $mimeType)) {
            return MediaInterface::VIDEO_TYPE;
        }

        return MediaInterface::FILE_TYPE;
    }
}
