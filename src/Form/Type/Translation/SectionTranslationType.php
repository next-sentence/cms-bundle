<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type\Translation;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class SectionTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'lwc_cms.ui.name',
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'lwc_cms_section_translation';
    }
}
