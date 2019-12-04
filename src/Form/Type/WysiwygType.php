<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class WysiwygType extends AbstractType
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'lwc_cms.ui.content',
            'config' => [
                'filebrowserUploadUrl' => $this->urlGenerator->generate('lwc_cms_admin_upload_editor_image'),
                'bodyId' => 'lwc-ckeditor',
            ],
        ]);
    }

    public function getParent(): string
    {
        return CKEditorType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'lwc_wysiwyg';
    }
}
