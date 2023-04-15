<?php

namespace App\Repository;

use App\Entity\Service;
use App\Object\Filter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function save(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Filter $filter
     * @return Paginator<Service>
     */
    public function findList(Filter $filter): Paginator
    {
        $qb = $this->createQueryBuilder('s');

        $qb
            ->setFirstResult($filter->getLimitOffset()->getOffset())
            ->setMaxResults($filter->getLimitOffset()->getLimit());

        if ($filter->getSearch()) {
            $qb
                ->andWhere($qb->expr()->orX(
                    $qb->expr()->like('s.title', ':search'),
                ))
                ->setParameter('search', '%' . $filter->getSearch() . '%');
        }

        $qb->addOrderBy('s.sort');

        return new Paginator($qb);
    }
}
