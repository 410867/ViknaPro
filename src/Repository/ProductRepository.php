<?php

namespace App\Repository;

use App\Entity\Product;
use App\Object\Filter;
use App\Object\ProductFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param ProductFilter $filter
     * @return Paginator<Product>
     */
    public function findList(ProductFilter $filter): Paginator
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->setFirstResult($filter->getLimitOffset()->getOffset())
            ->setMaxResults($filter->getLimitOffset()->getLimit());

        if ($filter->getSearch()) {
            $qb
                ->leftJoin('p.category', 'pc')
                ->leftJoin('p.collection', 'pco')
                ->andWhere($qb->expr()->orX(
                    $qb->expr()->like('p.title', ':search'),
                    $qb->expr()->like('pc.title', ':search'),
                    $qb->expr()->like('pco.title', ':search'),
                ))
                ->setParameter('search', '%' . $filter->getSearch() . '%');
        }

        if ($filter->getCollectionId()){
            $qb
                ->andWhere('p.collection = :collection')
                ->setParameter('collection', $filter->getCollectionId());
        }

        $qb->addOrderBy('p.sort');

        return new Paginator($qb);
    }
}
