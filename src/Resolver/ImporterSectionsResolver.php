<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Assigner\SectionsAssignerInterface;
use Lwc\CmsBundle\Entity\SectionableInterface;

final class ImporterSectionsResolver implements ImporterSectionsResolverInterface
{
    /** @var SectionsAssignerInterface */
    private $sectionsAssigner;

    public function __construct(SectionsAssignerInterface $sectionsAssigner)
    {
        $this->sectionsAssigner = $sectionsAssigner;
    }

    public function resolve(SectionableInterface $sectionable, ?string $sectionsRow): void
    {
        if (null === $sectionsRow) {
            return;
        }

        $sectionCodes = explode(',', $sectionsRow);
        $sectionCodes = array_map(function (string $element): string {
            return trim($element);
        }, $sectionCodes);

        $this->sectionsAssigner->assign($sectionable, $sectionCodes);
    }
}
