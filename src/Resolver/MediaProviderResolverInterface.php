<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Entity\MediaInterface;
use Lwc\CmsBundle\MediaProvider\ProviderInterface;

interface MediaProviderResolverInterface
{
    public function resolveProvider(MediaInterface $media): ProviderInterface;
}
