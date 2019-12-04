<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\MediaProvider;

use Lwc\CmsBundle\Entity\MediaInterface;

interface ProviderInterface
{
    public function getTemplate(): string;

    public function render(MediaInterface $media, array $options = []): string;

    public function upload(MediaInterface $media): void;
}
