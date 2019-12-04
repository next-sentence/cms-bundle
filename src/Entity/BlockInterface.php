<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface BlockInterface extends
    ResourceInterface,
    TranslatableInterface,
    ToggleableInterface,
    SectionableInterface,
    ContentableInterface
{
    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getContent(): ?string;

    public function setContent(?string $content): void;

    public function getLink(): ?string;

    public function setLink(?string $link): void;
}
