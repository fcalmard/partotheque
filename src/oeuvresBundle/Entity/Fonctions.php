<?php

namespace oeuvresBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fonctions
 *
 * @ORM\Table(name="Fonctions",uniqueConstraints={@ORM\UniqueConstraint(name="codeFonction_idx", columns={"code"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\FonctionsRepository")
 * @UniqueEntity(fields={"code"}, message="Cette fonction existe déja")
 * @UniqueEntity(fields={"libelle"}, message="Cette fonction existe déja")
 * 
 */
class Fonctions
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
     * @ORM\Column(name="code", type="string", length=10, unique=true)
     */
    private $code;
    
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
    public function getCode()
    {
    	return $this->code;
    }
    /**
     *
     * @param string $p
     * @return \oeuvresBundle\Entity\Genres
     */
    public function setCode($l)
    {
    	$this->code=$l;
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
     * @return \oeuvresBundle\Entity\Genres
     */
    public function setLibelle($l)
    {
    	$this->libelle=$l;
    	return $this;
    }    
       
    /**
     *
     */
    public function getActive()
    {
    	return ($this->active==1 ? true : false);
    }
    
    /**
     *
     * @param integer $a
     * @return \oeuvresBundle\Entity\Genres
     */
    public function setActive($a)
    {
    	$this->active=$a;
    	return $this;
    }    
    /**
     * Set datecreateAt
     *
     * @param \DateTime $datecreateAt
     * @return \oeuvresBundle\Entity\Genres
     */
    public function setDatecreateAt($datecreateAt)
    {
        $this->datecreateAt = $datecreateAt;
        return $this;
    }

    /**
     * 
     */
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
