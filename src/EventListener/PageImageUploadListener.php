<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\EventListener;

use Lwc\CmsBundle\Entity\PageInterface;
use Lwc\CmsBundle\Entity\PageTranslationInterface;
use Lwc\CmsBundle\Uploader\ImageUploaderInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Webmozart\Assert\Assert;

final class PageImageUploadListener
{
    /** @var ImageUploaderInterface */
    private $uploader;

    public function __construct(ImageUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadImage(ResourceControllerEvent $event): void
    {
        $page = $event->getSubject();

        Assert::isInstanceOf($page, PageInterface::class);

        /** @var PageTranslationInterface $translation */
        foreach ($page->getTranslations() as $translation) {
            $image = $translation->getImage();

            if (null !== $image && true === $image->hasFile()) {
                $this->uploader->upload($image);
            }
        }
    }
}
