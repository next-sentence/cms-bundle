<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait SectionableTrait
{
    /** @var Collection|SectionInterface[] */
    protected $sections;

    public function initializeSectionsCollection(): void
    {
        $this->sections = new ArrayCollection();
    }

    public function getSections(): ?Collection
    {
        return $this->sections;
    }

    public function hasSection(SectionInterface $section): bool
    {
        return $this->sections->contains($section);
    }

    public function addSection(SectionInterface $section): void
    {
        if (false === $this->hasSection($section)) {
            $this->sections->add($section);
        }
    }

    public function removeSection(SectionInterface $section): void
    {
        if (true === $this->hasSection($section)) {
            $this->sections->removeElement($section);
        }
    }
}
