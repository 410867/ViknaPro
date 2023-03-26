<?php

namespace App\Repository;

use App\Entity\Factory;
use App\Object\Filter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Factory>
 *
 * @method Factory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Factory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Factory[]    findAll()
 * @method Factory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Factory::class);
    }

    public function save(Factory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Factory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Filter $filter
     * @return Paginator<Factory>
     */
    public function findList(Filter $filter): Paginator
    {
        $qb = $this->createQueryBuilder('f');

        $qb
            ->setFirstResult($filter->getLimitOffset()->getOffset())
            ->setMaxResults($filter->getLimitOffset()->getLimit());

        if ($filter->getSearch()) {
            $qb
                ->leftJoin('f.category', 'fc')
                ->andWhere($qb->expr()->orX(
                    $qb->expr()->like('f.title', ':search'),
                    $qb->expr()->like('fc.title', ':search'),
                ))
                ->setParameter('search', '%' . $filter->getSearch() . '%');
        }

        $qb->addOrderBy('f.sort');

        return new Paginator($qb);
    }
}
