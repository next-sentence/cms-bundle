<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

interface MediaTypeResolverInterface
{
    public function resolveType(string $mimeType): string;
}
