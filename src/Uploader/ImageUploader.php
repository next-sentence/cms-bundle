<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Uploader;

use Gaufrette\Filesystem;
use Lwc\CmsBundle\Entity\ImageInterface;
use Symfony\Component\HttpFoundation\File\File;
use Webmozart\Assert\Assert;

class ImageUploader implements ImageUploaderInterface
{
    /** @var Filesystem */
    protected $filesystem;

    public function __construct(
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function upload(ImageInterface $image): void
    {
        if (!$image->hasFile()) {
            return;
        }

        $file = $image->getFile();

        /** @var File $file */
        Assert::isInstanceOf($file, File::class);

        if (null !== $image->getPath() && $this->has($image->getPath())) {
            $this->remove($image->getPath());
        }

        do {
            $hash = bin2hex(random_bytes(16));
            $path = $this->expandPath($hash . '.' . $file->guessExtension());
        } while ($this->filesystem->has($path));

        $image->setPath($path);

        $this->filesystem->write(
            $image->getPath(),
            file_get_contents($image->getFile()->getPathname())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function remove(string $path): bool
    {
        if ($this->filesystem->has($path)) {
            return $this->filesystem->delete($path);
        }

        return false;
    }

    private function has(string $path): bool
    {
        return $this->filesystem->has($path);
    }

    private function expandPath(string $path): string
    {
        return sprintf(
            '%s/%s/%s',
            substr($path, 0, 2),
            substr($path, 2, 2),
            substr($path, 4)
        );
    }
}