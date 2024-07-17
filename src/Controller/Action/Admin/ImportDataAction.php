<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Controller\Action\Admin;

use Lwc\CmsBundle\Controller\Helper\FormErrorsFlashHelperInterface;
use Lwc\CmsBundle\Exception\ImportFailedException;
use Lwc\CmsBundle\Form\Type\ImportType;
use Lwc\CmsBundle\Processor\ImportProcessorInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ImportDataAction
{
    /** @var ImportProcessorInterface */
    private $importProcessor;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var FormErrorsFlashHelperInterface */
    private $formErrorsFlashHelper;

    /** @var TranslatorInterface */
    private $translator;

    /** @var ViewHandler */
    private $viewHandler;

    public function __construct(
        ImportProcessorInterface $importProcessor,
        FormFactoryInterface $formFactory,
        FormErrorsFlashHelperInterface $formErrorsFlashHelper,
        TranslatorInterface $translator,
        ViewHandler $viewHandler
    ) {

        $this->importProcessor = $importProcessor;
        $this->formFactory = $formFactory;
        $this->formErrorsFlashHelper = $formErrorsFlashHelper;
        $this->translator = $translator;
        $this->viewHandler = $viewHandler;
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(ImportType::class);
        $referer = (string) $request->headers->get('referer');

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted()) {
            if ($form->isValid()) {
                /** @var UploadedFile $file */
                $file = $form->get('file')->getData();
                $resourceName = $request->get('resourceName');

                try {
                    $this->importProcessor->process($resourceName, $file->getPathname());

                    $request->getSession()->getFlashBag()->set('success', $this->translator->trans('lwc_cms.ui.successfully_imported'));
                } catch (ImportFailedException $exception) {
                    $request->getSession()->getFlashBag()->set('error', $exception->getMessage());
                }
            } else {
                $this->formErrorsFlashHelper->addFlashErrors($form);
            }

            return new RedirectResponse($referer);
        }

        $view = View::create()
            ->setData([
                'form' => $form->createView(),
            ])
            ->setTemplate('@LwcCms/Grid/Form/_importForm.html.twig')
        ;

        return $this->viewHandler->handle($view);
    }
}
