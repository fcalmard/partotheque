<?php

namespace oeuvresBundle\Entity;

use Symfony\Component\Translation\Tests\String;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\inverseJoinColumn;
use Doctrine\ORM\Mapping\inverseJoinColumns;

/**
 * langues_oeuvres
 *
 * @ORM\Table(name="langues_oeuvres")
 * 
 */
class langues_oeuvres
{

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="langues_id", type="integer")
	 */
	private $langues_id;
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="oeuvres_id", type="integer")
	 */
	private $oeuvres_id;	

    /**
     * Constructor
     */
    public function __construct()
    {
            
    }
    
    
}
