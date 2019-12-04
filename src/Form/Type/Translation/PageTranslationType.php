<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type\Translation;

use Lwc\CmsBundle\Form\Type\PageImageType;
use Lwc\CmsBundle\Form\Type\WysiwygType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class PageTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'lwc_cms.ui.name',
            ])
            ->add('slug', TextType::class, [
                'label' => 'lwc_cms.ui.slug',
            ])
            ->add('breadcrumb', TextType::class, [
                'label' => 'lwc_cms.ui.breadcrumb',
                'required' => false,
            ])
            ->add('nameWhenLinked', TextType::class, [
                'label' => 'lwc_cms.ui.name_when_linked',
                'required' => false,
            ])
            ->add('descriptionWhenLinked', TextareaType::class, [
                'label' => 'lwc_cms.ui.description_when_linked',
                'required' => false,
            ])
            ->add('image', PageImageType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('metaKeywords', TextareaType::class, [
                'label' => 'lwc_cms.ui.meta_keywords',
                'required' => false,
            ])
            ->add('metaDescription', TextareaType::class, [
                'label' => 'lwc_cms.ui.meta_description',
                'required' => false,
            ])
            ->add('content', WysiwygType::class)
            ->add('title', TextType::class, [
                'label' => 'lwc_cms.ui.title',
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'lwc_cms_page_translation';
    }
}
