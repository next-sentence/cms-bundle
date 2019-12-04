<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Repository;

use Lwc\CmsBundle\Entity\PageInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface PageRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder;

    public function findEnabled(bool $enabled): array;

    public function findOneEnabledByCode(string $code, ?string $localeCode): ?PageInterface;

    public function findOneEnabledBySlug(
        string $slug,
        ?string $localeCode
    ): ?PageInterface;

    public function createShopListQueryBuilder(string $sectionCode): QueryBuilder;

    public function findBySectionCode(string $sectionCode, ?string $localeCode): array;
}
