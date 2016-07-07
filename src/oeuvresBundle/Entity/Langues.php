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
 * Langues
 *
 * @ORM\Table(name="Langues",uniqueConstraints={@ORM\UniqueConstraint(name="codeLangues_idx", columns={"code"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\LanguesRepository")
 * @UniqueEntity(fields={"code"}, message="Cette langue existe déja")
 * 
 */
class Langues
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
     * @var integer 
     *
     * @ORM\ManyToMany(targetEntity="Oeuvres")
     * ,joinColumns={@JoinColumn(name="langues_id", referencedColumnName="id")}
     * ,inverseJoinColumns={@JoinColumn(name="oeuvres_id", referencedColumnName="id")}
     * )
     */
    private $Oeuvres;
        
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
    	return ($this->active==1 ? true : false);
    }

    /**
     * 
     * @param integer $a
     * @return \oeuvresBundle\Entity\Langues
     */
    public function setActive($a)
    {
    	$this->active=$a;
    	return $this;
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
     * @param string $code
     * @return \oeuvresBundle\Entity\Langues
     */
    public function setCode($code)
    {
    	$this->code=$code;
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
     * @return \oeuvresBundle\Entity\Langues
     */    
    public function setLibelle($l)
    {
    	$this->libelle=$l;
    	return $this;
    }

    /**
     * 
     */
    public function getOeuvres()
    {
    	return $this->Oeuvres;
    }
    /**
     * Add Oeuvres
     *
     * @param oeuvresBundle\Entity\Oeuvres $oeuvre
     */
    public function addOeuvre($oeuvre)
    {
    	// Si l'objet fait déjà partie de la collection on ne l'ajoute pas
    	if (!$this->Oeuvres->contains($oeuvre)) {
    		if (!$oeuvre->getLangues()->contains($this)) {
    			$oeuvre->addLangue($this);  // Lie LANGUE a l OEUVRE
    		}
    		$this->Oeuvres->add($langue);
    		 
    	}
    	return $this;
    }
    
    /**
     * Remove Oeuvres
     *
     * @param oeuvresBundle\Entity\Oeuvres $oeuvre
     */
    public function removeOeuvre(oeuvresBundle\Entity\Oeuvres $oeuvre)
    {
    	if ($this->Oeuvres->contains($oeuvre)) {
    		$this->Oeuvres->removeElement($oeuvre);
    	}
    }    
    /**
     * Set datecreateAt
     *
     * @param \DateTime $datecreateAt
     * @return \oeuvresBundle\Entity\Langues
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
        
        $this->Oeuvres = new \Doctrine\Common\Collections\ArrayCollection();
        
            
    }
    
    
}
