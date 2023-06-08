<?php

namespace App\Repository;

use App\Entity\Fonction;
use App\Search\SearchFonction;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Fonction>
 *
 * @method Fonction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fonction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fonction[]    findAll()
 * @method Fonction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FonctionRepository extends ServiceEntityRepository
{   
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    public function __construct(ManagerRegistry $registry,  PaginatorInterface $paginator)
    {
        parent::__construct($registry, Fonction::class);
        $this->paginator = $paginator;
    }

    public function add(Fonction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fonction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param SearchFonction $search
     * @return PaginationInterface
     */

    public function findSearch(SearchFonction $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('g')
            ->select('g');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('g.name LIKE :q')
                ->orWhere('g.description LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }
        return $this->paginator->paginate(
            $query,
            $search->page,
            10

        );
    }
}
