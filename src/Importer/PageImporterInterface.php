<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Importer;

interface PageImporterInterface extends ImporterInterface
{
    const CODE_COLUMN = 'code';
    const SECTIONS_COLUMN = 'sections';
    const SLUG_COLUMN = 'slug__locale__';
    const NAME_COLUMN = 'name__locale__';
    const IMAGE_COLUMN = 'image__locale__';
    const META_KEYWORDS_COLUMN = 'meta_keywords__locale__';
    const META_DESCRIPTION_COLUMN = 'meta_description__locale__';
    const CONTENT_COLUMN = 'content__locale__';
    const BREADCRUMB_COLUMN = 'breadcrumb__locale__';
    const NAME_WHEN_LINKED_COLUMN = 'name_when_linked__locale__';
    const DESCRIPTION_WHEN_LINKED_COLUMN = 'description_when_linked__locale__';
}
