<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Controller\Helper;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Translation\TranslatorInterface;

final class FormErrorsFlashHelper implements FormErrorsFlashHelperInterface
{
    /** @var FlashBagInterface */
    private $flashBag;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(FlashBagInterface $flashBag, TranslatorInterface $translator)
    {
        $this->flashBag = $flashBag;
        $this->translator = $translator;
    }

    public function addFlashErrors(FormInterface $form): void
    {
        if ($form->isValid()) {
            return;
        }

        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        $message = $this->translator->trans('lwc_cms.ui.form_was_submitted_with_errors') . ' ' . rtrim(implode($errors, " "));

        $this->flashBag->set('error', $message);
    }
}
