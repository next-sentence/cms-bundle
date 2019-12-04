<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Fixture\Factory;

use Lwc\CmsBundle\Assigner\SectionsAssignerInterface;
use Lwc\CmsBundle\Entity\BlockInterface;
use Lwc\CmsBundle\Entity\BlockTranslationInterface;
use Lwc\CmsBundle\Repository\BlockRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class BlockFixtureFactory implements FixtureFactoryInterface
{
    /** @var FactoryInterface */
    private $blockFactory;

    /** @var FactoryInterface */
    private $blockTranslationFactory;

    /** @var BlockRepositoryInterface */
    private $blockRepository;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var SectionsAssignerInterface */
    private $sectionsAssigner;
    public function __construct(
        FactoryInterface $blockFactory,
        FactoryInterface $blockTranslationFactory,
        BlockRepositoryInterface $blockRepository,
        LocaleContextInterface $localeContext,
        SectionsAssignerInterface $sectionsAssigner
    ) {
        $this->blockFactory = $blockFactory;
        $this->blockTranslationFactory = $blockTranslationFactory;
        $this->blockRepository = $blockRepository;
        $this->localeContext = $localeContext;
        $this->sectionsAssigner = $sectionsAssigner;
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $block = $this->blockRepository->findOneBy(['code' => $code])
            ) {
                $this->blockRepository->remove($block);
            }

            if (null !== $fields['number']) {
                for ($i = 0; $i < $fields['number']; ++$i) {
                    $this->createBlock(md5(uniqid()), $fields);
                }
            } else {
                $this->createBlock($code, $fields);
            }
        }
    }

    private function createBlock(string $code, array $blockData): void
    {
        /** @var BlockInterface $block */
        $block = $this->blockFactory->createNew();

        $this->sectionsAssigner->assign($block, $blockData['sections']);

        $block->setCode($code);
        $block->setEnabled($blockData['enabled']);

        foreach ($blockData['translations'] as $localeCode => $translation) {
            /** @var BlockTranslationInterface $blockTranslation */
            $blockTranslation = $this->blockTranslationFactory->createNew();

            $blockTranslation->setLocale($localeCode);
            $blockTranslation->setName($translation['name']);
            $blockTranslation->setContent($translation['content']);
            $blockTranslation->setLink($translation['link']);
            $block->addTranslation($blockTranslation);
        }

        $this->blockRepository->add($block);
    }
}
