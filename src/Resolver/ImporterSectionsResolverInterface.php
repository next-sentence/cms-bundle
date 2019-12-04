<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Entity\SectionableInterface;

interface ImporterSectionsResolverInterface
{
    public function resolve(SectionableInterface $sectionable, ?string $sectionsRow): void;
}
