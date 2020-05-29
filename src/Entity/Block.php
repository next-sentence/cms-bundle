<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class Block implements BlockInterface
{
    use ToggleableTrait;
    use SectionableTrait;
    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->initializeSectionsCollection();
    }

    /** @var int */
    protected $id;

    /** @var string */
    protected $code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getName(): ?string
    {
        return $this->getBlockTranslation()->getName();
    }

    public function setName(?string $name): void
    {
        $this->getBlockTranslation()->setName($name);
    }

    public function getContent(): ?string
    {
        return $this->getBlockTranslation()->getContent();
    }

    public function setContent(?string $content): void
    {
        $this->getBlockTranslation()->setContent($content);
    }

    public function getLink(): ?string
    {
        return $this->getBlockTranslation()->getLink();
    }

    public function setLink(?string $link): void
    {
        $this->getBlockTranslation()->setLink($link);
    }

    /**
     * @return BlockTranslationInterface|TranslationInterface
     */
    protected function getBlockTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    protected function createTranslation(): BlockTranslationInterface
    {
        return new BlockTranslation();
    }
}
