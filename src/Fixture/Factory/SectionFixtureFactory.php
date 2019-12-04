<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Fixture\Factory;

use Lwc\CmsBundle\Entity\SectionInterface;
use Lwc\CmsBundle\Entity\SectionTranslationInterface;
use Lwc\CmsBundle\Repository\SectionRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class SectionFixtureFactory implements FixtureFactoryInterface
{
    /** @var FactoryInterface */
    private $sectionFactory;

    /** @var FactoryInterface */
    private $sectionTranslationFactory;

    /** @var SectionRepositoryInterface */
    private $sectionRepository;

    public function __construct(
        FactoryInterface $sectionFactory,
        FactoryInterface $sectionTranslationFactory,
        SectionRepositoryInterface $sectionRepository
    ) {
        $this->sectionFactory = $sectionFactory;
        $this->sectionTranslationFactory = $sectionTranslationFactory;
        $this->sectionRepository = $sectionRepository;
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $section = $this->sectionRepository->findOneBy(['code' => $code])
            ) {
                $this->sectionRepository->remove($section);
            }

            /** @var SectionInterface $section */
            $section = $this->sectionFactory->createNew();

            $section->setCode($code);

            foreach ($fields['translations'] as $localeCode => $translation) {
                /** @var SectionTranslationInterface $sectionTranslation */
                $sectionTranslation = $this->sectionTranslationFactory->createNew();

                $sectionTranslation->setLocale($localeCode);
                $sectionTranslation->setName($translation['name']);

                $section->addTranslation($sectionTranslation);
            }

            $this->sectionRepository->add($section);
        }
    }
}
