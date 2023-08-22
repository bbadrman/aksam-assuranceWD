<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Prospect; 
use App\Search\SearchProspect;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository; 

/**
 * @extends ServiceEntityRepository<Prospect>
 *
 * @method Prospect|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prospect|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prospect[]    findAll()
 * @method Prospect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProspectRepository extends ServiceEntityRepository
{
   
    private $entityManager;
    private $paginator;
    private $security;


    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager, PaginatorInterface $paginator, Security $security )
    {
        parent::__construct($registry, Prospect::class);
       
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
        $this->security = $security;
    
    }

    public function add(Prospect $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Prospect $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

     /**
     * Find list a user by a search form
     * @param SearchProspect $search
     * @return PaginationInterface
     */
    public function findSearch(SearchProspect $search, User $user): PaginationInterface
    {

       
        $team = $user->getTeams();
        
        $query = $this
            ->createQueryBuilder('u')
            ->select('u, t, f')
            
            // joiner les tables en relation ManyToOne avec team
            ->leftJoin('u.team', 't')
           
           
            // joiner les tables en relation manytomany avec fonction
            ->leftJoin('u.comrcl', 'f');
           
            // ->where('t.id = :teamId')
            // ->setParameter('teamId', $team);
           
            // if ( $this->security->getUser()->getRoles() == 'ROLE_TEAM'){
            //     $query = $query
            //     ->where('u.team = :team')
            //    ->setParameter('team', $team);
           
            // }
            // if ((!empty($search)) ) {
            //     $query = $query
            //     ->where('u = 0');           
            // }
            
            if ((!empty($search->q)) ) {
            $query = $query
                ->andWhere('u.name LIKE :q')
                
                ->orderBy('u.id', 'desc')
                ->setParameter('q', "%{$search->q}%");
                
        }
          
           if (isset($search->m)) {
            $query = $query
                ->andWhere('u.lastname LIKE :m')
                ->setParameter('m', "%{$search->m}%");
              
        }
        if (isset($search->r)) {
            $query = $query
                ->andWhere('f.username LIKE :r')
                ->setParameter('r', "%{$search->r}%");
              
        }
        if (isset($search->g)) {
            $query = $query
                ->andWhere('u.email LIKE :g')
                ->setParameter('g', "%{$search->g}%");
              
        }
        if (isset($search->team)) {
            $query = $query
                 ->andWhere('t.name LIKE :team')
                 ->setParameter('team', "%{$search->team}%");
              
        }
        if (isset($search->l)) {
            $query = $query
                ->orWhere('u.phone LIKE :l')
                ->orWhere('u.gsm LIKE :l')
                ->setParameter('l', "%{$search->l}%");
              
        }
        if (isset($search->c)) {
            $query = $query
                ->andWhere('u.city LIKE :c')
                ->setParameter('c', "%{$search->c}%");
              
        }
        
        if (isset($search->d)) {
           
            $query = $query
            ->andWhere('u.creatAt >= :d')
            ->setParameter('d', $search->d->format('Y-m-d'));
              
        }
        if (isset($search->dd)) {
            $search->dd->modify('+23 hours 59 minutes 59 seconds');
            $query = $query
                // ->andWhere('u.creatAt LIKE :dd')
                 ->andWhere('u.creatAt <= :dd')
                 ->setParameter('dd', $search->dd->format('Y-m-d H:i:s'));
              
        }
        

        if (isset($search->s)) {
            $query = $query
                ->andWhere('u.raisonSociale LIKE :s')
                ->setParameter('s', "%{$search->s}%");
              
        }
        if (isset($search->source)) {
            $query = $query
                ->andWhere('u.source = :source')
                ->setParameter('source', $search->source);
        }
         
        return $this->paginator->paginate(
            $query,
            $search->page,
          
          50 
        );
    }
      /**
     * Find list a user by a search form
     * @param SearchProspect $search
     * @return PaginationInterface
     */
    public function findSearchChef(SearchProspect $search, User $user): PaginationInterface
    {
        $team = $user->getTeams();
        
         
        $query = $this
            ->createQueryBuilder('u')
            ->select('u')
           
             ->where('u = 0');
            // ->where('u.team = :team')
            
            // ->setParameter('team', $team)

            // ->andWhere("u.team is NOT NULL")
            // joiner les tables en relation ManyToOne avec team
            // ->leftJoin('u.team', 't')
            // joiner les tables en relation manytomany avec fonction
            // ->leftJoin('u.comrcl', 'f');

           
        //     if ((!empty($search->q)) ) {
        //     $query = $query
        //         ->Where('u.name LIKE :q')
               
        //         ->orderBy('u.id', 'desc')
        //         ->setParameter('q', "%{$search->q}%");
                
        // }
          
        // if (isset($search->m)) {
        //     $query = $query
        //         ->orWhere('u.lastname LIKE :m')
        //         ->setParameter('m', "%{$search->m}%");
              
        // }
        // if (isset($search->r)) {
        //     $query = $query
        //         ->orWhere('f.username LIKE :r')
        //         ->setParameter('r', "%{$search->r}%");
              
        // }
        // if (isset($search->g)) {
        //     $query = $query
        //         ->orWhere('u.email LIKE :g')
        //         ->setParameter('g', "%{$search->g}%");
              
        // }
     
        // if (isset($search->l)) {
        //     $query = $query
        //         ->orWhere('u.phone LIKE :l')
        //         ->orWhere('u.gsm LIKE :l')
        //         ->setParameter('l', "%{$search->l}%");
              
        // }
        // if (isset($search->c)) {
        //     $query = $query
        //         ->orWhere('u.city LIKE :c')
        //         ->setParameter('c', "%{$search->c}%");
              
        // }
        // if (isset($search->d)) {
        //     $query = $query
        //         ->andWhere('u.creatAt LIKE :d')
        //         ->setParameter('d', "%{$search->d}%");
              
        // }
        // if (isset($search->s)) {
        //     $query = $query
        //         ->orWhere('u.raisonSociale LIKE :s')
        //         ->setParameter('s', "%{$search->s}%");
              
        // }
        // if (isset($search->source)) {
        //     $query = $query
        //         ->orWhere('u.source = :source')
        //         ->setParameter('source', $search->source);
        // }
         
        return $this->paginator->paginate(
            $query,
            $search->page,
          15
           
        );
    }

   /**
    * @return Prospect[] Returns an array of Prospect objects 
    */
    public function findByUserConect($id): array
   {
    // dd($value);
       return $this->createQueryBuilder('p')
           ->andWhere('p.comrcl = :val')
           ->setParameter('val', $id)
           ->orderBy('p.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

    /**
    * @return Prospect[] Returns an array of Prospect objects
    * @param SearchProspect $search
    * @return PaginationInterface
    */
    public function findByUserAffecter(): array
    {
     // get selement les prospects qui sont affectter a un user
        return $this->createQueryBuilder('p')
            ->andWhere("p.comrcl != ''") 
            ->orWhere("p.team is NOT NULL") 
            ->orderBy('p.id', 'ASC') 
            ->getQuery()
            ->getResult()
        ;

        
    

     // get selement les prospects qui sont affectter a un comrcl
        // return $this->createQueryBuilder('p')
        //     ->andWhere("p.comrcl is NOT NULL") 
        //     ->orWhere("p.team is NOT NULL") 
        //     // ->andWhere("p.team != ''") 
        //     ->orderBy('p.id', 'ASC') 
        //     ->getQuery()
        //     ->getResult()
        // ;
    }

    /**
    * @return Prospect[] Returns an array of Prospect objects
    * @param SearchProspect $search
    * @return PaginationInterface
    */
    public function findByUserAffecterChef(User $user, SearchProspect $search): PaginationInterface
    {
        $team = $user->getTeams();

        $query = $this
            ->createQueryBuilder('u')
            ->select('u, t, f')
            ->where('u.team = :team')    
            ->setParameter('team', $team)
            ->andWhere("u.comrcl is NOT NULL") 
            ->andWhere("u.team is NOT NULL")
            // joiner les tables en relation ManyToOne avec team
            ->leftJoin('u.team', 't')
            // joiner les tables en relation manytomany avec fonction
            ->leftJoin('u.comrcl', 'f');
            //relation manytomany avec product apartir team
            // ->leftJoin('u.products', 'p');
           
           
        if (!empty($search->q)) {
            $query = $query
              
                ->Where('u.name LIKE :q')
                ->orWhere('u.lastname LIKE :m')
                ->orWhere('u.email LIKE :q')
                ->orWhere('u.city LIKE :q')
                ->orWhere('u.codePost LIKE :q') 
                ->orWhere('u.gender LIKE :q') 

            
                // join les tables              
                ->orWhere('t.name LIKE :q')
                ->orWhere('f.username LIKE :q')
                // ->orWhere('f.prospects LIKE :q')
                ->orWhere('u.phone LIKE :q')
                ->orWhere('u.gsm LIKE :q')
                ->orderBy('u.id', 'desc')
                ->setParameter('q', "%{$search->q}%");
        }
         
        if (isset($search->source)) {
            $query = $query
                ->andWhere('u.source = :source')
                ->setParameter('source', $search->source);
        }
        
        return $this->paginator->paginate(
            $query,
            $search->page,
            15
           
        );
     
    }

    /**
    * @return Prospect[] Returns an array of Prospect objects
    * @return PaginationInterface
    */
    public function findByUserPasAffecter(): array
    {
     // get selement les prospects qui n'as pas encors affectter a un user
     return  $this->createQueryBuilder('p')
            ->andWhere("p.comrcl is NULL") 
            ->andWhere("p.team is NULL") 
            ->orderBy('p.id', 'ASC') 
            ->getQuery()
            ->getResult()
            
        ;
        
             
         
        
    }


    /**
    * @return Prospect[] Returns an array of Prospect objects  
    */
    public function findByUserChefEquipe(User $user ): array
    {
        $team = $user->getTeams();
        
        $qb = $this->createQueryBuilder('p')
            ->where('p.team = :team')
            ->andWhere("p.comrcl is NULL") 
            ->setParameter('team', $team);

        $prospects = $qb->getQuery()->getResult();

        return $prospects;
 
 
         
          
         // select * from prospect join user on prospect.comrcl_id = user.id where prospect.comrcl_id = 2;
    }
       
     /**
    * @return Prospect[] Returns an array of Prospect objects  
    */
    public function findOneByChef(User $user ): array
    {
        $team = $user->getTeams();
        
        $qb = $this->createQueryBuilder('p')
            ->where('p.team = :team')
            ->andWhere("p.comrcl is NOT NULL") 
            ->setParameter('team', $team);

        $prospects = $qb->getQuery()->getResult();

        return $prospects;
 
 
         
          
         // select * from prospect join user on prospect.comrcl_id = user.id where prospect.comrcl_id = 2;
    }
         
 
}
