<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Importer;

use Lwc\CmsBundle\Entity\MediaInterface;
use Lwc\CmsBundle\Resolver\ImporterSectionsResolverInterface;
use Lwc\CmsBundle\Resolver\ResourceResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class MediaImporter extends AbstractImporter implements MediaImporterInterface
{
    /** @var ResourceResolverInterface */
    private $mediaResourceResolver;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ImporterSectionsResolverInterface */
    private $importerSectionsResolver;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ResourceResolverInterface $mediaResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterSectionsResolverInterface $importerSectionsResolver,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($validator);

        $this->mediaResourceResolver = $mediaResourceResolver;
        $this->localeContext = $localeContext;
        $this->importerSectionsResolver = $importerSectionsResolver;
        $this->entityManager = $entityManager;
    }

    public function import(array $row): void
    {
        /** @var string $code */
        $code = $this->getColumnValue(self::CODE_COLUMN, $row);
        Assert::notNull($code);
        /** @var MediaInterface $media */
        $media = $this->mediaResourceResolver->getResource($code);

        $media->setCode($code);
        $media->setType($this->getColumnValue(self::TYPE_COLUMN, $row));
        $media->setFallbackLocale($this->localeContext->getLocaleCode());

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $media->setCurrentLocale($locale);
            $media->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $media->setContent($this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row));
            $media->setAlt($this->getTranslatableColumnValue(self::ALT_COLUMN, $locale, $row));
        }

        $this->importerSectionsResolver->resolve($media, $this->getColumnValue(self::SECTIONS_COLUMN, $row));

        $this->validateResource($media, ['Lwc']);

        $media->getId() ?: $this->entityManager->persist($media);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'media';
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::NAME_COLUMN,
            self::CONTENT_COLUMN,
            self::ALT_COLUMN,
        ];
    }
}
