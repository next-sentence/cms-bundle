<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type;

use Lwc\CmsBundle\Form\Type\Translation\SectionTranslationType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class SectionType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'lwc_cms.ui.code',
                'disabled' => null !== $builder->getData()->getCode(),
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => SectionTranslationType::class,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'lwc_cms_section';
    }
}
