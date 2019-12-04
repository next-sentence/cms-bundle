<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Importer;

interface BlockImporterInterface extends ImporterInterface
{
    const CODE_COLUMN = 'code';
    const SECTIONS_COLUMN = 'sections';
    const NAME_COLUMN = 'name__locale__';
    const CONTENT_COLUMN = 'content__locale__';
    const LINK_COLUMN = 'link__locale__';
}
