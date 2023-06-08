<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;



class StatsService
{
    private $manager;
    private $security;

    public function __construct(EntityManagerInterface $manager, Security $security)
    {
        $this->manager = $manager;
        $this->security = $security;

    }
    public function getStats(){

        $user = $this->security->getUser();


        $users    = $this->getUsersCount();
        $teams      = $this->getTeamsCount();
        $products = $this->getProductsCount();
        $clients = $this->getClientsCount(); 
        $prospects = $this->getProspectCount();
        // $prospectParng = $this->getProspectParrainag();
        // $prospectAppl = $this->getProspectAppl();
        // $prospectAvn = $this->getProspectAvn(); 
        // $prospectAutre = $this->getProspectAutre(); 
        // $prospectAvnChef = $this->getProspectAvnChef($user);
        // $prospectApplChef = $this->getProspectApplChef($user);
        // $prospectParrngChef = $this->getProspectParrngChef($user);
        // $prospectAutreChef = $this->getProspectAutreChef($user); 

        $prospectPrngeEq = $this->getProspectParngEquipe($user);    
        $prospectAppeEq = $this->getProspectAppEquipe($user);     
        $prospectAvneEq = $this->getProspectAvnEquipe($user);    
        $prospectAutrEq = $this->getProspectAutrEquipe($user); 
        $prospectAncienEq = $this->getProspectAncienEquipe($user); 
        $prospectSiteEq = $this->getProspectSiteEquipe($user);  
        $prospectRevndEq = $this->getProspectRevendeurEquipe($user);   

        $prospectPrngeEqC = $this->getProspectParngEquipeC($user);    
        $prospectAppeEqC = $this->getProspectAppEquipeC($user);     
        $prospectAvneEqC = $this->getProspectAvnEquipeC($user);    
        $prospectAutrEqC = $this->getProspectAutrEquipeC($user); 
        $prospectAncienEqC = $this->getProspectAncienEquipeC($user); 
        $prospectSiteEqC = $this->getProspectSiteEquipeC($user); 
        $prospectRevndEqC = $this->getProspectRevendeurEquipeC($user); 

        $prospectPrngeEqA = $this->getProspectParngEquipeA($user);    
        $prospectAppeEqA = $this->getProspectAppEquipeA($user);     
        $prospectAvneEqA = $this->getProspectAvnEquipeA($user);    
        $prospectAutrEqA = $this->getProspectAutrEquipeA($user); 
        $prospectAncienEqA = $this->getProspectAnncEquipeA($user); 
        $prospectSiteEqA = $this->getProspectSiteEquipeA($user);  
        $prospectRevndEqA = $this->getProspectRevendeurEquipeA($user);   
       
        $prospectPrngeEqB = $this->getProspectParngEquipeB($user);    
        $prospectAppeEqB = $this->getProspectAppEquipeB($user);     
        $prospectAvneEqB = $this->getProspectAvnEquipeB($user);    
        $prospectAutrEqB = $this->getProspectAutrEquipeB($user);  
        $prospectAncienEqB = $this->getProspectAncienEquipeB($user);  
        $prospectSiteEqB = $this->getProspectSiteEquipeB($user);  
        $prospectRevndEqB = $this->getProspectRevendeurEquipeB($user);  

        $prospectTestEqB = $this->getProspectTestChef($user);    
        $prospectTetChef = $this->getProspectTetChef($user);   




        return compact('prospectRevndEqC', 'prospectSiteEqC', 'prospectRevndEqB', 'prospectSiteEqB', 'prospectRevndEq', 'prospectSiteEq', 'prospectRevndEqA', 'prospectSiteEqA', 'prospectAncienEq', 'prospectAncienEqC', 'prospectAncienEqB', 'prospectAncienEqA', 'prospectTestEqB', 'prospectTetChef', 'prospectAutrEqB', 'prospectAvneEqB', 'prospectAppeEqB', 'prospectPrngeEqB', 'prospectAutrEqA', 'prospectAvneEqA', 'prospectAppeEqA', 'prospectPrngeEqA', 'prospectAutrEqC', 'prospectAvneEqC', 'prospectAppeEqC', 'prospectPrngeEqC', 'prospectAutrEq', 'prospectAvneEq', 'prospectAppeEq', 'prospectPrngeEq', 'users', 'teams', 'products', 'clients', 'prospects');
    }

    // stat du chartjs
    public function getUsersCount(){
       return  $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
      
    }
    public function getTeamsCount(){
        return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\Team a')->getSingleScalarResult();
       
    }
    public function getProductsCount(){
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Product b')->getSingleScalarResult();
       
    } 
    public function getClientsCount(){
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Client c')->getSingleScalarResult();

    }
    public function getProspectCount(){
        return $this->manager->createQuery('SELECT COUNT(p) FROM App\Entity\Prospect p')->getSingleScalarResult();

    }

    // Prospects en Statique Admin
    // public function getProspectParrainag(){
    //     return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 1  AND m.comrcl is NULL AND m.team is NULL ')->getSingleScalarResult();

    // }
    // public function getProspectAppl(){
    //     return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 2  AND m.comrcl is NULL AND m.team is NULL ')->getSingleScalarResult();

    // }
    // public function getProspectAvn(){
    //     return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 3 AND m.comrcl is NULL AND m.team is NULL')->getSingleScalarResult();

    // }
    // public function getProspectAutre(){
    //     return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL AND m.comrcl is NULL AND m.team is NULL')->getSingleScalarResult();

    // }

    // Prospects en Statique Chef
    // public function getProspectAvnChef(User $user){
    //     $team = $user->getTeams();
         
    //     return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 3 AND  m.team = :team  AND m.comrcl is NULL ')->setParameter('team', $team)->getSingleScalarResult();

    // }
    // public function getProspectApplChef(User $user){
    //     $team = $user->getTeams();
         
    //     return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 2 AND  m.team = :team  AND m.comrcl is NULL ')->setParameter('team', $team)->getSingleScalarResult();

    // }
    // public function getProspectParrngChef(User $user){
    //     $team = $user->getTeams();
         
    //     return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 1 AND  m.team = :team  AND m.comrcl is NULL ')->setParameter('team', $team)->getSingleScalarResult();

    // }
    // public function getProspectAutreChef(User $user){
    //     $team = $user->getTeams();
         
    //     return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL AND  m.team = :team  AND m.comrcl is NULL ')->setParameter('team', $team)->getSingleScalarResult();

    // }

// test
    public function getProspectTestChef(User $user){
        $team = $user->getTeams();
         
        return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL AND  m.team = :team  AND m.comrcl = 4')->setParameter('team', $team)->getSingleScalarResult();

    }

    public function getProspectTetChef(User $user){
        $team = $user->getTeams();
         
        return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL AND  m.team = :team  AND m.comrcl = 6')->setParameter('team', $team)->getSingleScalarResult();

    }

    // Stat Affectation du  Admin 
   


//Equipe A
public function getProspectParngEquipeA(){
        
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 1 AND m.team = 1 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
} 

public function getProspectAppEquipeA(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 2 AND m.team = 1 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
}  
public function getProspectAvnEquipeA(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 3 AND m.team = 1 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
} 
public function getProspectAnncEquipeA(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 4 AND m.team = 1 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
} 
public function getProspectAutrEquipeA(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL AND m.team = 1 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
}
public function getProspectSiteEquipeA(){
    
    return $this->manager->createQuery("SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL AND m.source = 'Propre site' AND m.team = 1 AND m.comrcl is NOT NULL ")->getSingleScalarResult();
    
} 
public function getProspectRevendeurEquipeA(){
    
    return $this->manager->createQuery("SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL AND m.source = 'Revendeur' AND m.team = 1 AND m.comrcl is NOT NULL ")->getSingleScalarResult();
    
} 


//Equipe B
public function getProspectParngEquipeB(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 1 AND m.team = 4 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
}   
public function getProspectAppEquipeB(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 2 AND m.team = 4 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
}  
public function getProspectAvnEquipeB(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 3 AND m.team = 4 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
} 
public function getProspectAutrEquipeB(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL AND m.team = 4 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
} 

public function getProspectAncienEquipeB(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise  = 4  AND m.team = 4 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
}  


public function getProspectSiteEquipeB(){
    
    return $this->manager->createQuery("SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise  is NULL AND m.source = 'Propre site' AND m.team = 4 AND m.comrcl is NOT NULL ")->getSingleScalarResult();
    
}  

public function getProspectRevendeurEquipeB(){
    
    return $this->manager->createQuery("SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise  is NULL AND m.source = 'Revendeur' AND m.team = 4 AND m.comrcl is NOT NULL ")->getSingleScalarResult();
     
} 

//Equipe C
    public function getProspectParngEquipeC(){
        
        return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 1 AND m.team = 2 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
        
    }   
    public function getProspectAppEquipeC(){
        
        return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 2 AND m.team = 2 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
        
    }  
    public function getProspectAvnEquipeC(){
        
        return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 3 AND m.team = 2 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
        
    } 
    public function getProspectAutrEquipeC(){
        
        return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL AND m.team = 2 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
        
    }
    public function getProspectAncienEquipeC(){
        
        return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 4  AND m.team = 2 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
        
    }  

    public function getProspectSiteEquipeC(){
        
        return $this->manager->createQuery("SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL   AND m.source = 'Propre site'  AND m.team = 2 AND m.comrcl is NOT NULL ")->getSingleScalarResult();
        
    }    

    public function getProspectRevendeurEquipeC(){
        
        return $this->manager->createQuery("SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL  AND m.source = 'Revendeur'  AND m.team = 2 AND m.comrcl is NOT NULL ")->getSingleScalarResult();
        
    }   
  
  //Equipe D
  public function getProspectParngEquipe(){
        
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 1 AND m.team = 3 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
}   
public function getProspectAppEquipe(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 2 AND m.team = 3 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
}  
public function getProspectAvnEquipe(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 3 AND m.team = 3 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
} 

public function getProspectAncienEquipe(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise = 4 AND m.team = 3 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
} 

public function getProspectAutrEquipe(){
    
    return $this->manager->createQuery('SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL AND m.team = 3 AND m.comrcl is NOT NULL ')->getSingleScalarResult();
    
}


public function getProspectSiteEquipe(){
    
    return $this->manager->createQuery("SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL   AND m.source = 'Propre site' AND m.team = 3 AND m.comrcl is NOT NULL ")->getSingleScalarResult();
    
}  


public function getProspectRevendeurEquipe(){
    
    return $this->manager->createQuery("SELECT COUNT(m) FROM App\Entity\Prospect m WHERE m.motifSaise is NULL  AND m.source = 'Revendeur' AND m.team = 3 AND m.comrcl is NOT NULL ")->getSingleScalarResult();
    
}  

    // public function getAdsStats($direction){
    //     return $this->manager->createQuery(
    //         'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
    //         FROM App\Entity\Comment c
    //         JOIN c.ad a
    //         JOIN a.author u
    //         GROUP BY a
    //         ORDER BY note ' . $direction
    //     )
    //     ->setMaxResults(5)
    //     ->getResult();

    // }

    // public function getBestAds(){
    //     return $this->manager->createQuery(
    //         'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
    //         FROM App\Entity\Comment c
    //         JOIN c.ad a
    //         JOIN a.author u
    //         GROUP BY a
    //         ORDER BY note DESC'
    //     )
    //     ->setMaxResults(5)
    //     ->getResult();
    // }
    // public function getWorstAds(){
    //     return $this->manager->createQuery(
    //         'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
    //         FROM App\Entity\Comment c
    //         JOIN c.ad a
    //         JOIN a.author u
    //         GROUP BY a
    //         ORDER BY note ASC'
    //     )
    //     ->setMaxResults(5)
    //     ->getResult();
    // }
}
