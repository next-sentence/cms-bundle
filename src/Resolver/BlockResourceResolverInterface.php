<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Entity\BlockInterface;

interface BlockResourceResolverInterface
{
    public function findOrLog(string $code): ?BlockInterface;
}
