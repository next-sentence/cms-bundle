<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Fixture\Factory;

use Lwc\CmsBundle\Entity\FrequentlyAskedQuestionInterface;
use Lwc\CmsBundle\Entity\FrequentlyAskedQuestionTranslationInterface;
use Lwc\CmsBundle\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class FrequentlyAskedQuestionFixtureFactory implements FixtureFactoryInterface
{
    /** @var FactoryInterface */
    private $frequentlyAskedQuestionFactory;

    /** @var FactoryInterface */
    private $frequentlyAskedQuestionTranslationFactory;

    /** @var FrequentlyAskedQuestionRepositoryInterface */
    private $frequentlyAskedQuestionRepository;

    public function __construct(
        FactoryInterface $frequentlyAskedQuestionFactory,
        FactoryInterface $frequentlyAskedQuestionTranslationFactory,
        FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository
    ) {
        $this->frequentlyAskedQuestionFactory = $frequentlyAskedQuestionFactory;
        $this->frequentlyAskedQuestionTranslationFactory = $frequentlyAskedQuestionTranslationFactory;
        $this->frequentlyAskedQuestionRepository = $frequentlyAskedQuestionRepository;
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $frequentlyAskedQuestion = $this->frequentlyAskedQuestionRepository->findOneBy(['code' => $code])
            ) {
                $this->frequentlyAskedQuestionRepository->remove($frequentlyAskedQuestion);
            }

            if (null !== $fields['number']) {
                for ($i = 1; $i <= $fields['number']; ++$i) {
                    $this->createFrequentlyAskedQuestion(md5(uniqid()), $fields, $i);
                }
            } else {
                $this->createFrequentlyAskedQuestion($code, $fields, $fields['position']);
            }
        }
    }

    private function createFrequentlyAskedQuestion(string $code, array $frequentlyAskedQuestionData, int $position): void
    {
        /** @var FrequentlyAskedQuestionInterface $frequentlyAskedQuestion */
        $frequentlyAskedQuestion = $this->frequentlyAskedQuestionFactory->createNew();

        $frequentlyAskedQuestion->setCode($code);
        $frequentlyAskedQuestion->setEnabled($frequentlyAskedQuestionData['enabled']);
        $frequentlyAskedQuestion->setPosition($position);

        foreach ($frequentlyAskedQuestionData['translations'] as $localeCode => $translation) {
            /** @var FrequentlyAskedQuestionTranslationInterface $frequentlyAskedQuestionTranslation */
            $frequentlyAskedQuestionTranslation = $this->frequentlyAskedQuestionTranslationFactory->createNew();

            $frequentlyAskedQuestionTranslation->setLocale($localeCode);
            $frequentlyAskedQuestionTranslation->setQuestion($translation['question']);
            $frequentlyAskedQuestionTranslation->setAnswer($translation['answer']);

            $frequentlyAskedQuestion->addTranslation($frequentlyAskedQuestionTranslation);
        }

        $this->frequentlyAskedQuestionRepository->add($frequentlyAskedQuestion);
    }
}
