<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Repository;

use Lwc\CmsBundle\Entity\BlockInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface BlockRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder;

    public function findEnabledByCode(string $code): ?BlockInterface;

    public function findBySectionCode(
        string $sectionCode,
        string $localeCode
    ): array;
}
