<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Twig\Parser;

interface ContentParserInterface
{
    public function parse(string $input): string;
}
