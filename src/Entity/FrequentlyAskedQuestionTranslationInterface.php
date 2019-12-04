<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface FrequentlyAskedQuestionTranslationInterface extends TranslationInterface, ResourceInterface
{
    public function getQuestion(): ?string;

    public function setQuestion(string $question): void;

    public function getAnswer(): ?string;

    public function setAnswer(string $answer): void;
}
