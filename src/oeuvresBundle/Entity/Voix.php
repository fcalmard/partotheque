<?php

namespace oeuvresBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Voix
 *
 * @ORM\Table(name="Voix",uniqueConstraints={@ORM\UniqueConstraint(name="libelleVoix_idx", columns={"libelle"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\VoixRepository")
 * @UniqueEntity(fields={"libelle"}, message="Cette voix existe déja")
 * 
 */
class Voix
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
     * @ORM\Column(name="libelle", type="string", length=50, unique=true)
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
     * @return \oeuvresBundle\Entity\Voix
     */
    public function setActive($a)
    {
    	$this->active=($a==1) ? true: false;
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
     * @param string $l
     * @return \oeuvresBundle\Entity\Voix
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
     * @return \oeuvresBundle\Entity\Voix
     */
    public function setDatecreateAt($datecreateAt)
    {
        $this->datecreateAt = $datecreateAt;
        return $this;
    }

    public function __toString()
    {
    	return strval($this->id);
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datecreateAt = new \DateTime('now');
        $this->active=1;
            
    }
    
    
}
