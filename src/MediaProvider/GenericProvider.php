<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\MediaProvider;

use Lwc\CmsBundle\Entity\MediaInterface;
use Lwc\CmsBundle\Uploader\MediaUploaderInterface;
use Symfony\Component\Templating\EngineInterface;

final class GenericProvider implements ProviderInterface
{
    /** @var MediaUploaderInterface */
    private $uploader;

    /** @var EngineInterface */
    private $twigEngine;

    /** @var string */
    private $template;

    /** @var string */
    private $pathPrefix;

    public function __construct(
        MediaUploaderInterface $uploader,
        EngineInterface $twigEngine,
        string $template,
        string $pathPrefix
    ) {
        $this->uploader = $uploader;
        $this->twigEngine = $twigEngine;
        $this->template = $template;
        $this->pathPrefix = $pathPrefix;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function render(MediaInterface $media, array $options = []): string
    {
        return $this->twigEngine->render($this->template, array_merge(['media' => $media], $options));
    }

    public function upload(MediaInterface $media): void
    {
        $this->uploader->upload($media,  $this->pathPrefix);
    }
}
