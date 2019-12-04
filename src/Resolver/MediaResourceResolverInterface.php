<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Entity\MediaInterface;

interface MediaResourceResolverInterface
{
    public function findOrLog(string $code): ?MediaInterface;
}
