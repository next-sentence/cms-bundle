<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;

class FrequentlyAskedQuestionTranslation extends AbstractTranslation implements FrequentlyAskedQuestionTranslationInterface
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $question;

    /** @var string */
    protected $answer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }
}
