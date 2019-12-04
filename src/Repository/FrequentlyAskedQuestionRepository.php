<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Repository;

use Lwc\CmsBundle\Entity\FrequentlyAskedQuestionInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class FrequentlyAskedQuestionRepository extends EntityRepository implements FrequentlyAskedQuestionRepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->leftJoin('o.translations', 'translation', 'WITH', 'translation.locale = :localeCode')
            ->setParameter('localeCode', $localeCode)
        ;
    }

    public function findEnabledOrderedByPosition(string $localeCode): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->where('translation.locale = :localeCode')
            ->andWhere('o.enabled = true')
            ->orderBy('o.position', 'ASC')
            ->setParameter('localeCode', $localeCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneEnabledByCode(string $code): ?FrequentlyAskedQuestionInterface
    {
        return $this->createQueryBuilder('o')
            ->where('o.code = :code')
            ->andWhere('o.enabled = true')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
