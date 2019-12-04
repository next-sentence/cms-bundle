<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Form\Type;

use Lwc\CmsBundle\Form\Type\ImageType as BaseImageType;

final class PageImageType extends BaseImageType
{
    public function getBlockPrefix(): string
    {
        return 'lwc_cms_page_image';
    }
}
