<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Importer;

use Lwc\CmsBundle\Downloader\ImageDownloaderInterface;
use Lwc\CmsBundle\Entity\PageImage;
use Lwc\CmsBundle\Entity\PageInterface;
use Lwc\CmsBundle\Entity\PageTranslationInterface;
use Lwc\CmsBundle\Resolver\ImporterSectionsResolverInterface;
use Lwc\CmsBundle\Resolver\ResourceResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Lwc\CmsBundle\Uploader\ImageUploaderInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class PageImporter extends AbstractImporter implements PageImporterInterface
{
    /** @var ResourceResolverInterface */
    private $pageResourceResolver;

    /** @var ResourceResolverInterface */
    private $sectionResolver;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ImageDownloaderInterface */
    private $imageDownloader;

    /** @var ImageUploaderInterface */
    private $imageUploader;

    /** @var ImporterSectionsResolverInterface */
    private $importerSectionsResolver;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ResourceResolverInterface $pageResourceResolver,
        ResourceResolverInterface $sectionResolver,
        LocaleContextInterface $localeContext,
        ImageDownloaderInterface $imageDownloader,
        ImageUploaderInterface $imageUploader,
        ImporterSectionsResolverInterface $importerSectionsResolver,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($validator);

        $this->pageResourceResolver = $pageResourceResolver;
        $this->sectionResolver = $sectionResolver;
        $this->localeContext = $localeContext;
        $this->imageDownloader = $imageDownloader;
        $this->imageUploader = $imageUploader;
        $this->importerSectionsResolver = $importerSectionsResolver;
        $this->entityManager = $entityManager;
    }

    public function import(array $row): void
    {
        /** @var string $code */
        $code = $this->getColumnValue(self::CODE_COLUMN, $row);
        Assert::notNull($code);

        /** @var PageInterface $page */
        $page = $this->pageResourceResolver->getResource($code);

        $page->setCode($code);
        $page->setFallbackLocale($this->localeContext->getLocaleCode());

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $page->setCurrentLocale($locale);
            $page->setSlug($this->getTranslatableColumnValue(self::SLUG_COLUMN, $locale, $row));
            $page->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $page->setMetaKeywords($this->getTranslatableColumnValue(self::META_KEYWORDS_COLUMN, $locale, $row));
            $page->setMetaDescription($this->getTranslatableColumnValue(self::META_DESCRIPTION_COLUMN, $locale, $row));
            $page->setContent($this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row));
            $page->setBreadcrumb($this->getTranslatableColumnValue(self::BREADCRUMB_COLUMN, $locale, $row));
            $page->setNameWhenLinked($this->getTranslatableColumnValue(self::NAME_WHEN_LINKED_COLUMN, $locale, $row));
            $page->setDescriptionWhenLinked($this->getTranslatableColumnValue(self::DESCRIPTION_WHEN_LINKED_COLUMN, $locale, $row));

            $url = $this->getTranslatableColumnValue(self::IMAGE_COLUMN, $locale, $row);

            if (null !== $url) {
                $this->resolveImage($page, $url ?? '', $locale);
            }
        }

        $this->importerSectionsResolver->resolve($page, $this->getColumnValue(self::SECTIONS_COLUMN, $row));

        $this->validateResource($page, ['Lwc']);

        $page->getId() ?: $this->entityManager->persist($page);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'page';
    }

    private function resolveImage(PageInterface $page, string $url, string $locale): void
    {
        /** @var PageTranslationInterface $pageTranslation */
        $pageTranslation = $page->getTranslation($locale);
        $downloadedImage = $this->imageDownloader->download($url);

        if (null !== $pageImage = $pageTranslation->getImage()) {
            $this->imageUploader->remove($pageTranslation->getImage()->getPath());
        } else {
            $pageImage = new PageImage();
        }

        $pageImage->setFile($downloadedImage);
        $pageImage->setOwner($pageTranslation);

        $this->imageUploader->upload($pageImage);
        $this->entityManager->persist($pageImage);
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::SLUG_COLUMN,
            self::NAME_COLUMN,
            self::IMAGE_COLUMN,
            self::META_KEYWORDS_COLUMN,
            self::META_DESCRIPTION_COLUMN,
            self::CONTENT_COLUMN,
            self::BREADCRUMB_COLUMN,
            self::NAME_WHEN_LINKED_COLUMN,
            self::DESCRIPTION_WHEN_LINKED_COLUMN,
        ];
    }
}
