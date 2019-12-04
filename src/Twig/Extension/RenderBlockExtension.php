<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Twig\Extension;

use Lwc\CmsBundle\Repository\BlockRepositoryInterface;
use Lwc\CmsBundle\Resolver\BlockResourceResolverInterface;
use Symfony\Component\Templating\EngineInterface;

class RenderBlockExtension extends \Twig_Extension
{
    /** @var BlockRepositoryInterface */
    private $blockRepository;

    /** @var BlockResourceResolverInterface */
    private $blockResourceResolver;

    /** @var EngineInterface */
    private $templatingEngine;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockResourceResolverInterface $blockResourceResolver,
        EngineInterface $templatingEngine
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockResourceResolver = $blockResourceResolver;
        $this->templatingEngine = $templatingEngine;
    }

    public function getFunctions(): array
    {
        return [
            new \Twig_Function('lwc_cms_render_block', [$this, 'renderBlock'], ['is_safe' => ['html']]),
        ];
    }

    public function renderBlock(string $code, ?string $template = null): string
    {
        $block = $this->blockResourceResolver->findOrLog($code);

        if (null !== $block) {
            $template = $template ?? '@LwcCmsBundle/Shop/Block/show.html.twig';

            return $this->templatingEngine->render($template, ['block' => $block]);
        }

        return '';
    }
}
