<?php

namespace App\Repository;

use App\Entity\Team;
use App\Entity\User;
use App\Search\SearchUser;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, User::class);
        $this->paginator = $paginator;
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

   /**
     * Find list a user by a search form
     * @param SearchUser $search
     * @return PaginationInterface
     */
    public function findSearchUser(SearchUser $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('u')
            ->select('u, t, f, p')
            // joiner les tables en relation ManyToOne avec team
            ->leftJoin('u.teams', 't')
            // joiner les tables en relation manytomany avec fonction
            ->leftJoin('u.fonctions', 'f')
            //relation manytomany avec product apartir team
            ->leftJoin('u.products', 'p');
            
           
        if (!empty($search->q)) {
            $query = $query
                ->Where('u.firstname LIKE :q')
                ->orWhere('u.username LIKE :q')
                ->orWhere('u.lastname LIKE :q')
                ->orWhere('u.remuneration LIKE :q')
                ->orWhere('u.embuchAt LIKE :q') 
                ->orWhere('u.gender LIKE :q') 
                // join les tables              
                ->orWhere('t.name LIKE :q')
                ->orWhere('p.name LIKE :q')
                ->orWhere('f.name LIKE :q')

                ->orWhere('u.status LIKE :q')
                ->orderBy('u.id', 'desc')
                ->setParameter('q', "%{$search->q}%");
        }
        if (isset($search->gender)) {
            $query = $query
                ->andWhere('u.gender = :gender')
                ->setParameter('gender', $search->gender);
        }
        if (isset($search->status)) {
            $query = $query
                ->andWhere('u.status = :status')
                ->setParameter('status', $search->status);
        }
        return $this->paginator->paginate(
            $query,
            $search->page,
            10
           
        );
    }
    public function findComrclByteamOrderedByAscName(Team $team): array
    {
         
        return $this->createQueryBuilder('t')
            ->andWhere('t.teams = :teams')
            ->setParameter('teams', $team)
            // ->orderBy('u.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
    // selectionner les user activer
    public function findActifeCorcl(){

        
        // joiner les tables en relation ManyToOne avec team
        return $this->createQueryBuilder('u')
           ->andWhere('u.status = :val')
           ->setParameter('val', 1 )
           ->getQuery()
           ->getResult()
       ;

    }
}
