<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Repository;

use Lwc\CmsBundle\Entity\MediaInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface MediaRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder;

    public function findOneEnabledByCode(string $code): ?MediaInterface;

    public function findBySectionCode(string $sectionCode): array;

}
