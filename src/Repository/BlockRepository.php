<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Repository;

use Lwc\CmsBundle\Entity\BlockInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BlockRepository extends EntityRepository implements BlockRepositoryInterface
{
    public function createListQueryBuilder(string $localeCode): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->leftJoin('o.translations', 'translation', 'WITH', 'translation.locale = :localeCode')
            ->setParameter('localeCode', $localeCode)
        ;
    }

    public function findEnabledByCode(string $code): ?BlockInterface
    {
        return $this->createQueryBuilder('o')
            ->where('o.code = :code')
            ->andWhere('o.enabled = true')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findBySectionCode(string $sectionCode, string $localeCode): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.sections', 'section')
            ->andWhere('translation.locale = :localeCode')
            ->andWhere('section.code = :sectionCode')
            ->andWhere('o.enabled = true')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('sectionCode', $sectionCode)
            ->getQuery()
            ->getResult()
        ;
    }
}
