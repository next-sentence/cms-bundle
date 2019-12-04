<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Generator;

interface SlugGeneratorInterface
{
    public function generate(string $name): string;
}