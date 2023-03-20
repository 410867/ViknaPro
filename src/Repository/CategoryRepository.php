<?php

namespace App\Repository;

use App\Entity\Category;
use App\Object\CategoryFilter\CategoryFilter;
use App\Object\Filter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Filter $filter
     * @return Paginator|Category[]
     */
    public function findList(CategoryFilter $filter): Paginator
    {
        $qb = $this->createQueryBuilder('c');
        $qb->orderBy('c.sort');

        if ($filter->isRoot()) {
            $qb->andWhere($qb->expr()->isNull('c.parent'));
        }

        if ($filter->isChildren()) {
            $qb->andWhere($qb->expr()->isNotNull('c.parent'));
        }

        if ($filter->hasLimitOffset()) {
            $qb
                ->setFirstResult($filter->getLimitOffset()->getOffset())
                ->setMaxResults($filter->getLimitOffset()->getLimit());
        }

        if ($filter->getExcludeIds()) {
            $qb->andWhere($qb->expr()->notIn('c.id', $filter->getExcludeIds()));
        }

        if ($filter->getSearch()) {
            $qb
                ->leftJoin('c.children', 'cc')
                ->andWhere($qb->expr()->orX(
                    $qb->expr()->like('c.title', ':search'),
                    $qb->expr()->like('cc.title', ':search'),
                ))
                ->setParameter('search', '%' . $filter->getSearch() . '%');
        }

        return new Paginator($qb);
    }
}
