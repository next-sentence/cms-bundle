<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

interface ContentableInterface
{
    public function getContent(): ?string;
}
