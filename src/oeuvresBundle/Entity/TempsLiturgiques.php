<?php

namespace oeuvresBundle\Entity;

use Symfony\Component\Translation\Tests\String;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TempsLiturgiques
 *
 * @ORM\Table(name="TempsLiturgiques",uniqueConstraints={@ORM\UniqueConstraint(name="tpslLibelle_idx", columns={"libelle"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\TempsLiturgiquesRepository")
 * @UniqueEntity(fields={"libelle"}, message="Ce Tempsliturgique existe déja")
 * 
 */
class TempsLiturgiques
{

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer")
     */
    private $active;
        
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, unique=true)
     */
    private $libelle;    
     
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreateAt", type="datetime")
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()     *
     */
    private $datecreateAt;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    
    /**
     * 
     */
    public function getActive()
    {
    	return $this->active==1;
    }

    /**
     * 
     * @param integer $a
     * @return \oeuvresBundle\Entity\Tempsliturgiques
     */
    public function setActive($a)
    {
    	$this->active=($a==1) ? true:false;;
    	return $this;
    }    
      
    /**
     * 
     */
    public function getLibelle()
    {
    	 return $this->libelle;
    }
    /**
     * 
     * @param string $p
     * @return \oeuvresBundle\Entity\Tempsliturgiques
     */    
    public function setLibelle($l)
    {
    	$this->libelle=$l;
    	return $this;
    }
       
    /**
     * Set datecreateAt
     *
     * @param \DateTime $datecreateAt
     * @return \oeuvresBundle\Entity\Tempsliturgiques
     */
    public function setDatecreateAt($datecreateAt)
    {
        $this->datecreateAt = $datecreateAt;
        return $this;
    }

    /**
     * Get datecreateAt
     *
     * @return \DateTime 
     */
    public function getDatecreateAt()
    {
        return $this->datecreateAt;
    }
    
    public function __toString()
    {
    	return strval($this->id);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datecreateAt = new \DateTime('now');
        $this->active=1;
            
    }
    
    
}
