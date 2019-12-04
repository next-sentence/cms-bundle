<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Repository;

use Lwc\CmsBundle\Entity\FrequentlyAskedQuestionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface FrequentlyAskedQuestionRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder;

    public function findEnabledOrderedByPosition(string $localeCode): array;

    public function findOneEnabledByCode(string $code): ?FrequentlyAskedQuestionInterface;
}
