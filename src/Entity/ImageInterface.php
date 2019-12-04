<?php

declare(strict_types=1);

namespace Sylius\Component\Core\Model;

namespace Lwc\CmsBundle\Entity;

interface ImageInterface extends ResourceInterface
{
    /**
     * @return string
     */
    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getFile(): ?\SplFileInfo;

    public function setFile(?\SplFileInfo $file): void;

    public function hasFile(): bool;

    public function getPath(): ?string;

    public function setPath(?string $path): void;

    /**
     * @return object
     */
    public function getOwner();

    /**
     * @param object|null $owner
     */
    public function setOwner($owner): void;
}