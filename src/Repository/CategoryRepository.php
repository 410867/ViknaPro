<?php

namespace App\Repository;

use App\Entity\Category;
use App\Object\Category\CategoryFilter;
use App\Object\Filter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
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
     * @param CategoryFilter $filter
     * @return Paginator<Category>
     */
    public function findList(CategoryFilter $filter): Paginator
    {
        $qb = $this->createQueryBuilder('c');

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

        if ($filter->isSortByNesting()){
            $qb
                ->addOrderBy('c.nesting');
        }

        $qb->addOrderBy('c.sort');

        return new Paginator($qb);
    }

    /**
     * @throws Exception
     */
    public function getAllImages(int $limit = 9): array
    {
        $sql = 'select json_array_elements(images) img 
from category where images is not null and json_array_length(images) >= 0 order by sort ASC limit :limit';
        $items = $this->_em->getConnection()->executeQuery($sql, ['limit' => $limit])->fetchAllAssociative();

        return array_map(fn (array $item) => str_replace(['"', '\\'], '', $item['img']), $items);
    }
}
