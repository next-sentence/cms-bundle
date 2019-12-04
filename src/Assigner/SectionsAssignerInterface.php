<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Assigner;

use Lwc\CmsBundle\Entity\SectionableInterface;

interface SectionsAssignerInterface
{
    public function assign(SectionableInterface $sectionable, array $sectionsCodes): void;
}
