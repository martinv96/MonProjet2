<?php

namespace App\Repository;

use App\Entity\TodosList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TodosList>
 *
 * @method TodosList|null find($id, $lockMode = null, $lockVersion = null)
 * @method TodosList|null findOneBy(array $criteria, array $orderBy = null)
 * @method TodosList[]    findAll()
 * @method TodosList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodosListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TodosList::class);
    }

    public function save(TodosList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TodosList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByName(string $title): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.title LIKE :title')
            ->setParameter('title', '%' . $title . '%')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
