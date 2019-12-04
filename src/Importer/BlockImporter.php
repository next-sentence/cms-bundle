<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Importer;

use Lwc\CmsBundle\Entity\BlockInterface;
use Lwc\CmsBundle\Resolver\ImporterSectionsResolverInterface;
use Lwc\CmsBundle\Resolver\ResourceResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class BlockImporter extends AbstractImporter implements BlockImporterInterface
{
    /** @var ResourceResolverInterface */
    private $blockResourceResolver;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ImporterSectionsResolverInterface */
    private $importerSectionsResolver;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ResourceResolverInterface $blockResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterSectionsResolverInterface $importerSectionsResolver,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($validator);

        $this->blockResourceResolver = $blockResourceResolver;
        $this->localeContext = $localeContext;
        $this->importerSectionsResolver = $importerSectionsResolver;
        $this->entityManager = $entityManager;
    }

    public function import(array $row): void
    {
        /** @var string $code */
        $code = $this->getColumnValue(self::CODE_COLUMN, $row);
        Assert::notNull($code);
        /** @var BlockInterface $block */
        $block = $this->blockResourceResolver->getResource($code);

        $block->setCode($code);
        $block->setFallbackLocale($this->localeContext->getLocaleCode());

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $block->setCurrentLocale($locale);
            $block->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $block->setLink($this->getTranslatableColumnValue(self::LINK_COLUMN, $locale, $row));
            $block->setContent($this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row));
        }

        $this->importerSectionsResolver->resolve($block, $this->getColumnValue(self::SECTIONS_COLUMN, $row));

        $this->validateResource($block, ['Lwc']);

        $block->getId() ?: $this->entityManager->persist($block);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'block';
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::NAME_COLUMN,
            self::CONTENT_COLUMN,
            self::LINK_COLUMN,
        ];
    }
}
