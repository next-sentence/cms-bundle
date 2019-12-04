<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Fixture\Factory;

use Lwc\CmsBundle\Assigner\SectionsAssignerInterface;
use Lwc\CmsBundle\Entity\PageImage;
use Lwc\CmsBundle\Entity\PageInterface;
use Lwc\CmsBundle\Entity\PageTranslationInterface;
use Lwc\CmsBundle\Repository\PageRepositoryInterface;
use Lwc\CmsBundle\Uploader\ImageUploaderInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class PageFixtureFactory implements FixtureFactoryInterface
{
    /** @var FactoryInterface */
    private $pageFactory;

    /** @var FactoryInterface */
    private $pageTranslationFactory;

    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var ImageUploaderInterface */
    private $imageUploader;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var SectionsAssignerInterface */
    private $sectionsAssigner;

    public function __construct(
        FactoryInterface $pageFactory,
        FactoryInterface $pageTranslationFactory,
        PageRepositoryInterface $pageRepository,
        ImageUploaderInterface $imageUploader,
        SectionsAssignerInterface $sectionsAssigner,
        LocaleContextInterface $localeContext
    ) {
        $this->pageFactory = $pageFactory;
        $this->pageTranslationFactory = $pageTranslationFactory;
        $this->pageRepository = $pageRepository;
        $this->imageUploader = $imageUploader;
        $this->sectionsAssigner = $sectionsAssigner;
        $this->localeContext = $localeContext;
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $page = $this->pageRepository->findOneBy(['code' => $code])
            ) {
                $this->pageRepository->remove($page);
            }

            if (null !== $fields['number']) {
                for ($i = 0; $i < $fields['number']; ++$i) {
                    $this->createPage(md5(uniqid()), $fields, true);
                }
            } else {
                $this->createPage($code, $fields);
            }
        }
    }

    private function createPage(string $code, array $pageData, bool $generateSlug = false): void
    {
        /** @var PageInterface $page */
        $page = $this->pageFactory->createNew();


        $this->sectionsAssigner->assign($page, $pageData['sections']);

        $page->setCode($code);
        $page->setEnabled($pageData['enabled']);

        foreach ($pageData['translations'] as $localeCode => $translation) {
            /** @var PageTranslationInterface $pageTranslation */
            $pageTranslation = $this->pageTranslationFactory->createNew();
            $slug = true === $generateSlug ? md5(uniqid()) : $translation['slug'];

            $pageTranslation->setLocale($localeCode);
            $pageTranslation->setSlug($slug);
            $pageTranslation->setName($translation['name']);
            $pageTranslation->setMetaKeywords($translation['meta_keywords']);
            $pageTranslation->setMetaDescription($translation['meta_description']);
            $pageTranslation->setContent($translation['content']);

            if ($translation['image_path']) {
                $image = new PageImage();
                $path = $translation['image_path'];
                $uploadedImage = new UploadedFile($path, md5($path) . '.jpg');

                $image->setFile($uploadedImage);
                $pageTranslation->setImage($image);

                $this->imageUploader->upload($image);
            }

            $page->addTranslation($pageTranslation);
        }

        $this->pageRepository->add($page);
    }
}
