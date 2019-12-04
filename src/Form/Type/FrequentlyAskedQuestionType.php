<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type;

use Lwc\CmsBundle\Form\Type\Translation\FrequentlyAskedQuestionTranslationType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class FrequentlyAskedQuestionType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'lwc_cms.ui.code',
                'disabled' => null !== $builder->getData()->getCode(),
            ])
            ->add('position', IntegerType::class, [
                'label' => 'lwc_cms.ui.position',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'lwc_cms.ui.enabled',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'label' => false,
                'entry_type' => FrequentlyAskedQuestionTranslationType::class,
            ])
        ;
    }
}
