<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Importer;

interface MediaImporterInterface extends ImporterInterface
{
    const CODE_COLUMN = 'code';
    const TYPE_COLUMN = 'type';
    const SECTIONS_COLUMN = 'sections';
    const NAME_COLUMN = 'name__locale__';
    const CONTENT_COLUMN = 'content__locale__';
    const ALT_COLUMN = 'alt__locale__';
}
