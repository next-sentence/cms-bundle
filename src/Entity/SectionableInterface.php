<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Doctrine\Common\Collections\Collection;

interface SectionableInterface
{
    public function initializeSectionsCollection(): void;

    /**
     * @return Collection|SectionInterface[]
     */
    public function getSections(): ?Collection;

    public function hasSection(SectionInterface $section): bool;

    public function addSection(SectionInterface $section): void;

    public function removeSection(SectionInterface $section): void;
}
