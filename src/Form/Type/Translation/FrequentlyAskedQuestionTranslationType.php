<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type\Translation;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class FrequentlyAskedQuestionTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', TextType::class, [
                'label' => 'lwc_cms.ui.question',
            ])
            ->add('answer', TextareaType::class, [
                'label' => 'lwc_cms.ui.answer',
            ])
        ;
    }
}
