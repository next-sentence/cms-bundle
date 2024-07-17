<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Controller\Helper;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

final class FormErrorsFlashHelper implements FormErrorsFlashHelperInterface
{
    /** @var Request */
    private $request;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->request = $requestStack->getCurrentRequest();
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

        if ($this->request) {
            $this->request->getSession()->getFlashBag()->set('error', $message);
        }
    }
}
