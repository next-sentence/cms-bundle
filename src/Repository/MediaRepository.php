<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Repository;

use Lwc\CmsBundle\Entity\MediaInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository implements MediaRepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
        ;
    }

    public function findOneEnabledByCode(string $code): ?MediaInterface
    {
        return $this->createQueryBuilder('o')
            ->where('o.code = :code')
            ->andWhere('o.enabled = true')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findBySectionCode(string $sectionCode): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.sections', 'section')
            ->andWhere('section.code = :sectionCode')
            ->andWhere('o.enabled = true')
            ->setParameter('sectionCode', $sectionCode)
            ->getQuery()
            ->getResult()
        ;
    }
}
