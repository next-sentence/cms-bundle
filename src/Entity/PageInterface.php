<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface PageInterface extends
    ResourceInterface,
    TranslatableInterface,
    ToggleableInterface,
    SectionableInterface,
    TimestampableInterface,
    ContentableInterface
{
    public function getSlug(): ?string;

    public function setSlug(?string $slug): void;

    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getMetaKeywords(): ?string;

    public function setMetaKeywords(?string $metaKeywords): void;

    public function getMetaDescription(): ?string;

    public function setMetaDescription(?string $metaDescription): void;

    public function getContent(): ?string;

    public function setContent(?string $content): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getNameWhenLinked(): ?string;

    public function setNameWhenLinked(?string $nameWhenLinked): void;

    public function getBreadcrumb(): ?string;

    public function setBreadcrumb(?string $breadcrumb): void;

    public function getDescriptionWhenLinked(): ?string;

    public function setDescriptionWhenLinked(?string $descriptionWhenLinked): void;

    public function getTitle(): ?string;

    public function setTitle(?string $title): void;
}
