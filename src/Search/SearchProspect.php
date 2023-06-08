<?php

namespace App\Search;

use DateTime;

class SearchProspect
{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';

     /**
     * @var string
     */
    public $m = '';

    /**
     * @var string
     */
    public $g = '';
    
    /**
     * @var string
     */
    public $l = '';

    /**
     * @var string
     */
    public  $team = '';

    /**
     * @var string
     */
    public $c = '';

    /**
     * @var string
     */
    public $r = '';
    /**
     * @var string
     */
    public $s = '';

    /**
     * @var string
     */
    public $d;

    /**
     * @var string
     */
    public $dd;
    // public function getD(): ?DateTime
    // {
    //     return $this->d;
    // }

    // public function setD(string $d): self
    // {
    //     $this->d = DateTime::createFromFormat('Y-m-d', $d);
    //     return $this;
    // }

    

     /**
     * @var int
     */
    public $source; 
    
}