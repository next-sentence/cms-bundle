<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Repository;

use Lwc\CmsBundle\Entity\SectionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface SectionRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder;

    public function findByNamePart(string $phrase, ?string $locale = null): array;

    public function findOneByCode(string $code, ?string $localeCode): ?SectionInterface;

    public function findByCodesAndLocale(string $codes, string $localeCode): array;
}
