<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Controller;

use Lwc\CmsBundle\Entity\MediaInterface;
use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

final class MediaController extends ResourceController
{
    public function renderMediaAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');
        $mediaResourceResolver = $this->get('lwc_cms.resolver.media_resource');
        $media = $mediaResourceResolver->findOrLog($code);

        if (null === $media) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $media);

        $mediaProviderResolver = $this->get('lwc_cms.resolver.media_provider');

        return new Response($mediaProviderResolver->resolveProvider($media)->render($media));
    }

    public function downloadMediaAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');
        $mediaResourceResolver = $this->get('lwc_cms.resolver.media_resource');
        /** @var MediaInterface $media */
        $media = $mediaResourceResolver->findOrLog($code);

        if (null === $media) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $media);

        $mediaPath = $this->getParameter('lwc.public_dir') . '/' . $media->getPath();
        $mediaFile = new File($mediaPath);
        $mediaName = $media->getName() . '.' . $mediaFile->guessExtension();
        $response = new BinaryFileResponse($mediaPath);

        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $mediaName);
        $response->headers->set('Content-Type', $media->getMimeType());

        return $response;
    }

    public function previewAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::CREATE);
        /** @var MediaInterface $media */
        $media = $request->get('id') && $this->repository->find($request->get('id')) ?
            $this->repository->find($request->get('id')) :
            $this->factory->createNew();
        $form = $this->resourceFormFactory->create($configuration, $media);
        $mediaTemplate = null;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $defaultLocale = $this->getParameter('locale');
            $mediaTemplate = $this->get('lwc_cms.resolver.media_provider')->resolveProvider($media)->getTemplate();

            $this->resolveFile($media);

            $media->setFallbackLocale($request->get('_locale', $defaultLocale));
            $media->setCurrentLocale($request->get('_locale', $defaultLocale));
        }

        $this->get('lwc_cms.controller.helper.form_errors_flash')->addFlashErrors($form);

        $view = View::create()
            ->setData([
                'resource' => $media,
                $this->metadata->getName() => $media,
                'mediaTemplate' => $mediaTemplate,
            ])
            ->setTemplate($configuration->getTemplate(ResourceActions::CREATE . '.html'))
        ;

        return $this->viewHandler->handle($configuration, $view);
    }

    private function resolveFile(MediaInterface $media): void
    {
        if (!$media->getFile() && !$media->getPath()) {
            return;
        }

        $file = $media->getFile() ?: new File($this->getParameter('lwc.public_dir') . '/' . $media->getPath());
        $base64Content = base64_encode(file_get_contents($file->getPathname()));
        $path = 'data:' . $file->getMimeType() . ';base64, ' . $base64Content;

        $media->setPath($path);
    }
}
