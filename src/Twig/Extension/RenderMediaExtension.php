<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Twig\Extension;

use Lwc\CmsBundle\Resolver\MediaProviderResolverInterface;
use Lwc\CmsBundle\Resolver\MediaResourceResolverInterface;

final class RenderMediaExtension extends \Twig_Extension
{
    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    /** @var MediaResourceResolverInterface */
    private $mediaResourceResolver;

    public function __construct(
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaResourceResolverInterface $mediaResourceResolver
    ) {
        $this->mediaProviderResolver = $mediaProviderResolver;
        $this->mediaResourceResolver = $mediaResourceResolver;
    }

    public function getFunctions(): array
    {
        return [
            new \Twig_Function('lwc_cms_render_media', [$this, 'renderMedia'], ['is_safe' => ['html']]),
        ];
    }

    public function renderMedia(string $code): string
    {
        $media = $this->mediaResourceResolver->findOrLog($code);

        if (null !== $media) {
            return $this->mediaProviderResolver->resolveProvider($media)->render($media);
        }

        return '';
    }
}
