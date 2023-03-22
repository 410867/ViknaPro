<?php

namespace App\Repository;

use App\Entity\CategoryCollection;
use App\Object\Filter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryCollection>
 *
 * @method CategoryCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryCollection[]    findAll()
 * @method CategoryCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryCollection::class);
    }

    public function save(CategoryCollection $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategoryCollection $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Filter $filter
     * @return Paginator|CategoryCollection
     */
    public function findList(Filter $filter): Paginator
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->setFirstResult($filter->getLimitOffset()->getOffset())
            ->setMaxResults($filter->getLimitOffset()->getLimit());

        if ($filter->getSearch()) {
            $qb
                ->leftJoin('c.category', 'cc')
                ->andWhere($qb->expr()->orX(
                    $qb->expr()->like('c.title', ':search'),
                    $qb->expr()->like('cc.title', ':search'),
                ))
                ->setParameter('search', '%' . $filter->getSearch() . '%');
        }

        $qb->addOrderBy('c.sort');

        return new Paginator($qb);
    }
}
