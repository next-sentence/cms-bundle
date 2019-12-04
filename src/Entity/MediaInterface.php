<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Symfony\Component\HttpFoundation\File\File;

interface MediaInterface extends
    ResourceInterface,
    TranslatableInterface,
    ToggleableInterface,
    SectionableInterface,
    ContentableInterface
{
    public const IMAGE_TYPE = 'image';
    public const VIDEO_TYPE = 'video';
    public const FILE_TYPE = 'file';

    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getPath(): ?string;

    public function setPath(?string $path): void;

    public function getFile(): ?File;

    public function setFile(?File $file): void;

    public function hasFile(): bool;

    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getMimeType(): ?string;

    public function setMimeType(?string $mimeType): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getContent(): ?string;

    public function setContent(?string $content): void;

    public function getAlt(): ?string;

    public function setAlt(?string $alt): void;

    public function getLink(): ?string;

    public function setLink(?string $link): void;
}
