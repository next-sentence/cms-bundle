<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Controller;

use Lwc\CmsBundle\Generator\SlugGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class PageSlugController
{
    /** @var SlugGeneratorInterface */
    private $slugGenerator;

    public function __construct(SlugGeneratorInterface $slugGenerator)
    {
        $this->slugGenerator = $slugGenerator;
    }

    public function generateAction(Request $request): JsonResponse
    {
        $name = $request->query->get('name');

        return new JsonResponse([
            'slug' => $this->slugGenerator->generate($name),
        ]);
    }
}
