<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface PageTranslationInterface extends ResourceInterface, TranslationInterface
{
    public function getContent(): ?string;

    public function setContent(?string $content): void;

    public function getSlug(): ?string;

    public function setSlug(?string $slug): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getBreadcrumb(): ?string;

    public function setBreadcrumb(?string $breadcrumb): void;

    public function getNameWhenLinked(): ?string;

    public function setNameWhenLinked(?string $nameWhenLinked): void;

    public function getDescriptionWhenLinked(): ?string;

    public function setDescriptionWhenLinked(?string $descriptionWhenLinked): void;

    public function getMetaKeywords(): ?string;

    public function setMetaKeywords(?string $metaKeywords): void;

    public function getMetaDescription(): ?string;

    public function setMetaDescription(?string $metaDescription): void;

    public function getImage(): ?PageImageInterface;

    public function setImage(?PageImageInterface $image): void;

    public function getTitle(): ?string;

    public function setTitle(?string $title): void;
}
