<?php

namespace oeuvresBundle\Entity;

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
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=7, unique=false)
     */
    private $couleur;
    
    /**
     * @var string
     *
     * @ORM\Column(name="couleurfg", type="string", length=7, unique=false)
     */
    private $couleurfg;
        
    /**
     * @var integer
     *
     * @ORM\Column(name="couleurdef", type="integer")
     */
    private $couleurdef;
    
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
     *
     */
    public function getCouleur()
    {
    	return $this->couleur;
    }
    /**
     *
     * @param string $p
     * @return \oeuvresBundle\Entity\Tempsliturgiques
     */
    public function setCouleur($c)
    {
    	$this->couleur=$c;
    	return $this;
    }
    /**
     *
     */
    public function getCouleurfg()
    {
    	return $this->couleurfg;
    }
    /**
     *
     * @param string $p
     * @return \oeuvresBundle\Entity\Tempsliturgiques
     */
    public function setCouleurfg($c)
    {
    	$this->couleurfg=$c;
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
     *
     */
    public function getCouleurdef()
    {
    	return $this->couleurdef==1;
    }
    
    /**
     *
     * @param integer $a
     * @return \oeuvresBundle\Entity\Tempsliturgiques
     */
    public function setCouleurdef($a)
    {
    	$this->couleurdef=($a==1) ? true:false;;
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
        $this->couleurdef=1;
            
    }
    
    
}
