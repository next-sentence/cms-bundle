<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Entity\MediaInterface;
use Lwc\CmsBundle\MediaProvider\ProviderInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class MediaProviderResolver implements MediaProviderResolverInterface
{
    /** @var ServiceRegistryInterface */
    private $providerRegistry;

    public function __construct(ServiceRegistryInterface $providerRegistry)
    {
        $this->providerRegistry = $providerRegistry;
    }

    public function resolveProvider(MediaInterface $media): ProviderInterface
    {
        /** @var ProviderInterface $provider */
        $provider = $this->providerRegistry->get($media->getType());

        return $provider;
    }
}
