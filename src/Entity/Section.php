<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class Section implements SectionInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    /** @var int */
    protected $id;

    /** @var string */
    protected $code;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
    }

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
        return $this->getSectionTranslation()->getName();
    }

    public function setName(?string $name): void
    {
        $this->getSectionTranslation()->setName($name);
    }

    /**
     * @return TranslationInterface|SectionTranslationInterface
     */
    protected function getSectionTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    protected function createTranslation(): TranslationInterface
    {
        return new SectionTranslation();
    }
}
