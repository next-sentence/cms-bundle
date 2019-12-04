<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface FrequentlyAskedQuestionInterface extends
    ResourceInterface,
    TranslatableInterface,
    ToggleableInterface
{
    public function getCode(): ?string;

    public function setCode(?string $code): void;

    /**
     * @return int|null
     */
    public function getPosition(): ?int;

    public function setPosition(?int $position): void;

    public function getQuestion(): ?string;

    public function setQuestion(?string $question): void;

    public function getAnswer(): ?string;

    public function setAnswer(?string $answer): void;
}
