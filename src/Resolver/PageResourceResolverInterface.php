<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Entity\PageInterface;

interface PageResourceResolverInterface
{
    public function findOrLog(string $code): ?PageInterface;
}
