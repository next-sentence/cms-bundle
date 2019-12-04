<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type;

use Lwc\CmsBundle\Entity\BlockInterface;
use Lwc\CmsBundle\Form\Type\Translation\BlockTranslationType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;

final class BlockType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var BlockInterface $block */
        $block = $builder->getData();

        $builder
            ->add('code', TextType::class, [
                'label' => 'lwc_cms.ui.code',
                'disabled' => null !== $block->getCode(),
            ])
            ->add('sections', SectionAutocompleteChoiceType::class, [
                'label' => 'lwc_cms.ui.sections',
                'multiple' => true,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'lwc_cms.ui.enabled',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'label' => 'lwc_cms.ui.contents',
                'entry_type' => BlockTranslationType::class,
                'validation_groups' => ['lwc_content'],
                'constraints' => [new Valid()],
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'lwc_cms_block';
    }
}
