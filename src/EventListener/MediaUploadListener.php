<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\EventListener;

use Lwc\CmsBundle\Entity\MediaInterface;
use Lwc\CmsBundle\Resolver\MediaProviderResolverInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Webmozart\Assert\Assert;

final class MediaUploadListener
{
    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    public function __construct(MediaProviderResolverInterface $mediaProviderResolver)
    {
        $this->mediaProviderResolver = $mediaProviderResolver;
    }

    public function uploadMedia(ResourceControllerEvent $event): void
    {
        /** @var MediaInterface $media */
        $media = $event->getSubject();

        Assert::isInstanceOf($media, MediaInterface::class);

        $this->mediaProviderResolver->resolveProvider($media)->upload($media);
    }
}
