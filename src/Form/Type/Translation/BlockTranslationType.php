<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type\Translation;

use Lwc\CmsBundle\Form\Type\WysiwygType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class BlockTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'lwc_cms.ui.name',
                'required' => false,
            ])
            ->add('link', TextType::class, [
                'label' => 'lwc_cms.ui.link',
                'required' => false,
            ])
            ->add('content', WysiwygType::class, [
                'required' => false
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'lwc_cms_text_translation';
    }
}
