<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Generator;

use Behat\Transliterator\Transliterator;

final class SlugGenerator implements SlugGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate(string $name): string
    {
        // Manually replacing apostrophes since Transliterator started removing them at v1.2.
        $name = str_replace('\'', '-', $name);

        return Transliterator::transliterate($name);
    }
}