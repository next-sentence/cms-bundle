<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Fixture\Factory;

use Lwc\CmsBundle\Assigner\SectionsAssignerInterface;
use Lwc\CmsBundle\Entity\MediaInterface;
use Lwc\CmsBundle\Entity\MediaTranslationInterface;
use Lwc\CmsBundle\Repository\MediaRepositoryInterface;
use Lwc\CmsBundle\Resolver\MediaProviderResolverInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\File;

final class MediaFixtureFactory implements FixtureFactoryInterface
{
    /** @var FactoryInterface */
    private $mediaFactory;

    /** @var FactoryInterface */
    private $mediaTranslationFactory;

    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    /** @var MediaRepositoryInterface */
    private $mediaRepository;

    /** @var SectionsAssignerInterface */
    private $sectionsAssigner;

    public function __construct(
        FactoryInterface $mediaFactory,
        FactoryInterface $mediaTranslationFactory,
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaRepositoryInterface $mediaRepository,
        SectionsAssignerInterface $sectionsAssigner
    ) {
        $this->mediaFactory = $mediaFactory;
        $this->mediaTranslationFactory = $mediaTranslationFactory;
        $this->mediaProviderResolver = $mediaProviderResolver;
        $this->mediaRepository = $mediaRepository;
        $this->sectionsAssigner = $sectionsAssigner;
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $media = $this->mediaRepository->findOneBy(['code' => $code])
            ) {
                $this->mediaRepository->remove($media);
            }

            if (null !== $fields['number']) {
                for ($i = 0; $i < $fields['number']; ++$i) {
                    $this->createMedia(md5(uniqid()), $fields);
                }
            } else {
                $this->createMedia($code, $fields);
            }
        }
    }

    private function createMedia(string $code, array $mediaData): void
    {
        /** @var MediaInterface $media */
        $media = $this->mediaFactory->createNew();
        $media->setType($mediaData['type']);
        $media->setCode($code);
        $media->setEnabled($mediaData['enabled']);
        $media->setFile(new File($mediaData['path']));

        $this->mediaProviderResolver->resolveProvider($media)->upload($media);

        foreach ($mediaData['translations'] as $localeCode => $translation) {
            /** @var MediaTranslationInterface $mediaTranslation */
            $mediaTranslation = $this->mediaTranslationFactory->createNew();

            $mediaTranslation->setLocale($localeCode);
            $mediaTranslation->setName($translation['name']);
            $mediaTranslation->setContent($translation['content']);
            $mediaTranslation->setAlt($translation['alt']);
            $mediaTranslation->setLink($translation['link']);
            $media->addTranslation($mediaTranslation);
        }

        $this->sectionsAssigner->assign($media, $mediaData['sections']);

        $this->mediaRepository->add($media);
    }
}
