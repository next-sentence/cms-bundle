<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Twig\Extension;

use Lwc\CmsBundle\Entity\ContentableInterface;
use Lwc\CmsBundle\Twig\Parser\ContentParserInterface;

final class RenderContentExtension extends \Twig_Extension
{
    /** @var ContentParserInterface */
    private $contentParser;

    public function __construct(ContentParserInterface $contentParser)
    {
        $this->contentParser = $contentParser;
    }

    public function getFunctions(): array
    {
        return [
            new \Twig_Function('lwc_cms_render_content', [$this, 'renderContent'], ['is_safe' => ['html']]),
        ];
    }

    public function renderContent(ContentableInterface $contentableResource): string
    {
        $content = (string) html_entity_decode((string) $contentableResource->getContent(), ENT_QUOTES);

        return $this->contentParser->parse($content);
    }
}
