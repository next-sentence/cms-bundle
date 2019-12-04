<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Controller\Helper;

use Symfony\Component\Form\FormInterface;

interface FormErrorsFlashHelperInterface
{
    public function addFlashErrors(FormInterface $form): void;
}
