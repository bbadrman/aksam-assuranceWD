<?php

namespace App\Cart;
  
use App\Repository\ProspectRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Panier
{
    protected $session;
    protected $prospectRepository;

    public function __construct(SessionInterface $session, ProspectRepository $prospectRepository)
    {
        $this->session = $session;
        $this->prospectRepository = $prospectRepository;
    }


    public function getQty(): int {
         
        $prospect =  $this->prospectRepository->findAll();
        
        $qty = $this->session->get('prospect',  count($prospect));
        return $qty;
       
         
    }
    // public function getNmbr(): int {
         
    //     $prospect =  $this->prospectRepository->findAll();
        
    //     $nmbr = $this->session->get('prospect',  count($prospect));
    //     return $nmbr;
       
         
    // }

}

 