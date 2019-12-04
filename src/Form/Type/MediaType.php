<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type;

use Lwc\CmsBundle\Form\Type\Translation\MediaTranslationType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class MediaType extends AbstractResourceType
{
    /** @var array */
    private $providers;

    public function __construct(string $dataClass, array $validationGroups = [], array $providers = [])
    {
        parent::__construct($dataClass, $validationGroups);

        $this->providers = $providers;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'lwc_cms.ui.code',
                'disabled' => null !== $builder->getData()->getCode(),
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'lwc_cms.ui.type',
                'choices' => $this->providers,
            ])
            ->add('file', FileType::class, [
                'label' => 'lwc_cms.ui.file',
            ])
            ->add('sections', SectionAutocompleteChoiceType::class, [
                'label' => 'lwc_cms.ui.sections',
                'multiple' => true,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'lwc_cms.ui.enabled',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => MediaTranslationType::class,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'lwc_cms_media';
    }
}
