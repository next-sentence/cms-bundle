<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\MediaProvider;

use Lwc\CmsBundle\Entity\MediaInterface;
use Lwc\CmsBundle\Uploader\MediaUploaderInterface;
use Twig\Environment;

final class GenericProvider implements ProviderInterface
{
    /** @var MediaUploaderInterface */
    private $uploader;

    /** @var Environment */
    private $twig;

    /** @var string */
    private $template;

    /** @var string */
    private $pathPrefix;

    public function __construct(
        MediaUploaderInterface $uploader,
        Environment $twig,
        string $template,
        string $pathPrefix
    ) {
        $this->uploader = $uploader;
        $this->twig = $twig;
        $this->template = $template;
        $this->pathPrefix = $pathPrefix;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function render(MediaInterface $media, array $options = []): string
    {
        return $this->twig->render($this->template, array_merge(['media' => $media], $options));
    }

    public function upload(MediaInterface $media): void
    {
        $this->uploader->upload($media,  $this->pathPrefix);
    }
}
