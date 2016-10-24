<?php

namespace oeuvresBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Compositions
 *
 * @ORM\Table(name="Compositions")
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\CompositionsRepository")
 * 
 */
class Compositions
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
     *
     * @var integer
     *
     * @ORM\Column(name="instruments_id", type="integer",nullable=false)
     *
     */
    private $instruments_id;
    
    /**
     *
     * @var integer
     *
     * @ORM\Column(name="accompagnements_id", type="integer",nullable=false)
     *
     */
    private $accompagnements_id;    
        
    /**
     *
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer",nullable=false)
     *
     */
    private $quantite;
    

    
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
     * @return \oeuvresBundle\Entity\Compositions
     */
    public function setActive($a)
    {
    	$this->active=$a;
    	return $this;
    }    
    
    /**
     *
     * @param unknown_type integer
     * @return \oeuvresBundle\Entity\Compositions
     */
    public function setInstrumentsId($id)
    {
    	$this->instruments_id=$id;
    	return $this;
    }
    /**
     *
     */
    public function getInstrumentsId()
    {
    	return $this->instruments_id;
    }
    
    /**
     *
     * @param unknown_type integer
     * @return \oeuvresBundle\Entity\Compositions
     */
    public function setAccompagnementsId($id)
    {
    	$this->accompagnements_id=$id;
    	return $this;
    }
    /**
     *
     */
    public function getAccompagnementsId()
    {
    	return $this->accompagnements_id;
    }    

    /**
     * 
     * @param integer $q
     * @return \oeuvresBundle\Entity\Compositions
     */
    public function setQuantite($q)
    {
    	$this->quantite=$q;
    	return $this;
    	 
    }
    public function getQuantite()
    {
    	return $this->quantite;
    }
    
    /**
     * Set datecreateAt
     *
     * @param \DateTime $datecreateAt
     * @return \oeuvresBundle\Entity\Compositions
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
        $this->quantite=1;
            
    }
    
    
}
