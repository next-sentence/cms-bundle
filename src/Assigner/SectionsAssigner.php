<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Assigner;

use Lwc\CmsBundle\Entity\SectionableInterface;
use Lwc\CmsBundle\Entity\SectionInterface;
use Lwc\CmsBundle\Repository\SectionRepositoryInterface;

final class SectionsAssigner implements SectionsAssignerInterface
{
    /** @var SectionRepositoryInterface */
    private $sectionRepository;

    public function __construct(SectionRepositoryInterface $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function assign(SectionableInterface $sectionsAware, array $sectionsCodes): void
    {
        foreach ($sectionsCodes as $sectionCode) {
            /** @var SectionInterface $section */
            $section = $this->sectionRepository->findOneBy(['code' => $sectionCode]);

            if (null !== $section) {
                $sectionsAware->addSection($section);
            }
        }
    }
}
