<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

final class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, [
            'required' => true,
            'constraints' => [
                new NotNull([
                    'message' => 'lwc_cms.import.not_blank',
                ]),
                new File([
                    'mimeTypes' => ['text/csv', 'text/plain'],
                    'mimeTypesMessage' => 'lwc_cms.import.invalid_format',
                ]),
            ],
        ]);
    }
}
