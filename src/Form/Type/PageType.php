<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type;

use Lwc\CmsBundle\Form\Type\Translation\PageTranslationType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class PageType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'lwc_cms.ui.code',
                'disabled' => null !== $builder->getData()->getCode(),
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'lwc_cms.ui.enabled',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'label' => 'lwc_cms.ui.images',
                'entry_type' => PageTranslationType::class,
            ])
            ->add('sections', SectionAutocompleteChoiceType::class, [
                'label' => 'lwc_cms.ui.sections',
                'multiple' => true,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'lwc_cms_page';
    }
}
