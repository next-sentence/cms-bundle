<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Entity\MediaInterface;
use Lwc\CmsBundle\Repository\MediaRepositoryInterface;
use Psr\Log\LoggerInterface;

final class MediaResourceResolver implements MediaResourceResolverInterface
{
    /** @var MediaRepositoryInterface */
    private $mediaRepository;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        MediaRepositoryInterface $mediaRepository,
        LoggerInterface $logger
    )
    {
        $this->mediaRepository = $mediaRepository;
        $this->logger = $logger;
    }

    public function findOrLog(string $code): ?MediaInterface
    {
        $media = $this->mediaRepository->findOneEnabledByCode($code);

        if (false === $media instanceof MediaInterface) {
            $this->logger->warning(sprintf(
                'Media with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        return $media;
    }
}
