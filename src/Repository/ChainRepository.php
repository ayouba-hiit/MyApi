<?php

namespace App\Repository;

use App\Entity\Chain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Chain>
 *
 * @method Chain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chain[]    findAll()
 * @method Chain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChainRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Chain::class);
        $this->paginator = $paginator;
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function getPaginatedList(int $page, int $limit): array
    {
        $qb = $this->createQueryBuilder('c');

        $pagination = $this->paginator->paginate($qb->getQuery(), $page, $limit);

        return $pagerResponse = [
            'count' => $pagination->getTotalItemCount(),
            'items' => $pagination->getItems(),
        ];
    }

    public function add(Chain $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Chain $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
