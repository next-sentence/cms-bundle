<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Controller;

use Lwc\CmsBundle\Entity\BlockInterface;
use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class BlockController extends ResourceController
{
    const BLOCK_TEMPLATE = '@LwcCms/Frontend/Block/show.html.twig';

    public function renderBlockAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');
        $blockResourceResolver = $this->get('lwc_cms.resolver.block_resource');
        $block = $blockResourceResolver->findOrLog($code);

        if (null === $block) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $block);

        $view = View::create($block);
        $template = $request->get('template') ?? self::BLOCK_TEMPLATE;

        if ($configuration->isHtmlRequest()) {
            $view
                ->setTemplate($template)
                ->setTemplateVar($this->metadata->getName())
                ->setData([
                    'configuration' => $configuration,
                    'metadata' => $this->metadata,
                    'resource' => $block,
                    $this->metadata->getName() => $block,
                ])
            ;
        }

        return $this->viewHandler->handle($configuration, $view);
    }

    public function previewAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::CREATE);
        /** @var BlockInterface $block */
        $block = $this->newResourceFactory->create($configuration, $this->factory);
        $form = $this->resourceFormFactory->create($configuration, $block);

        $form->handleRequest($request);

        /** @var BlockInterface $block */
        $block = $form->getData();
        $defaultLocale = $this->getParameter('locale');

        $block->setFallbackLocale($request->get('_locale', $defaultLocale));
        $block->setCurrentLocale($request->get('_locale', $defaultLocale));

        $view = View::create()
            ->setData([
                'resource' => $block,
                $this->metadata->getName() => $block,
                'blockTemplate' => self::BLOCK_TEMPLATE,
            ])
            ->setTemplate($configuration->getTemplate(ResourceActions::CREATE . '.html'))
        ;

        return $this->viewHandler->handle($configuration, $view);
    }
}
