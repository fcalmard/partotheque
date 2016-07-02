<?php

namespace oeuvresBundle\Entity;

use Symfony\Component\Translation\Tests\String;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Genres
 *
 * @ORM\Table(name="Genres",uniqueConstraints={@ORM\UniqueConstraint(name="codeGenres_idx", columns={"code"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\GenresRepository")
 * @UniqueEntity(fields={"code"}, message="Ce Genre existe déja")
 * 
 */
class Genres
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
     *
     * @var typesmus_id
     *
     * @ORM\Column(name="typesmus_id", type="integer",nullable=true)
     *
     */
    private $typesmus_id;
    /**
     *
     * @var string
     * @ORM\Column(name="historique", type="text",nullable=true)
     */
    private $historique;
  
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
     * @return \oeuvresBundle\Entity\Genres
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
     * @return \oeuvresBundle\Entity\Genres
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
    public function getTypesmusId()
    {
    	return $this->typesmus_id;
    }
    /**
     * 
     * @param integer $t
     * @return \oeuvresBundle\Entity\Genres
     */
    public function setTypesmusId($t)
    {
    	
    	$this->typesmus_id=$t;
    	return $this;
    }
    /**
    
    */
    public function getHistorique()
    {
    	return $this->historique;    
    }
    /**
     * 
     * @param string $historique
     * @return \oeuvresBundle\Entity\Genres
     */
    public function setHistorique($historique)
    {
   		$this->historique=$historique;
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
