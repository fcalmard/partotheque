<?php

namespace oeuvresBundle\Entity;
use \DateTime;

use Doctrine\ORM\Mapping as ORM;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Compositeurs
 *
 * @ORM\Table(name="Compositeurs",uniqueConstraints={@ORM\UniqueConstraint(name="Compositeurs_nom_idx", columns={"nom","prenom"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\CompositeursRepository")
 * @UniqueEntity(fields={"nom","prenom"}, message="Ce compositeur existe déja")
 * 
 */
class Compositeurs
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
     * @ORM\Column(name="active", type="integer")
     *
     */
    private $active;  
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, unique=false)
     */
    private $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, unique=false,nullable=true)
     */
    private $prenom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=50, unique=false,nullable=true)
     */
    private $nationalite;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datenaiss", type="string", length=50,nullable=true)
     * @ORM\Column(type="string")
     */
    private $datenaiss;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedeces", type="string", length=50,nullable=true)
     * @ORM\Column(type="string")
     */
    private $datedeces;
    
    /**
     *
     * @var string
     * @ORM\Column(name="historique", type="text",nullable=true)
     */
    private $historique;
        
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreateAt", type="datetime",nullable=true)
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
     */
    public function setActive($a)
    {
    	$this->active=($a==1) ? 1 : 0;
    	return $this;
    }
    
    public function getNom()
    {
    	return $this->nom;
    }
    /**
     *
     * @param string $nom
     * @return \oeuvresBundle\Entity\Compositeurs
     */
    public function setNom($nom)
    {
    	$this->nom=$nom;
    	return $this;
    }
    
    /**
     *
     */
    public function getPrenom()
    {
    	return $this->prenom;
    }
    /**
     *
     * @param string $p
     * @return \oeuvresBundle\Entity\Compositeurs
     */
    public function setPrenom($p)
    {
    	$this->prenom=$p;
    	return $this;
    }
    
    public function getNomPrenom()
    {
    	return $this->prenom." ".$this->nom;
    	 
    }
    /**
     *
     */
    public function getNationalite()
    {
    	return $this->nationalite;
    }
    /**
     *
     * @param string $n
     * @return \oeuvresBundle\Entity\Compositeurs
     */
    public function setNationalite($n)
    {
    	$this->nationalite=$n;
    	return $this;
    }
    
    /**
     *
     */
    public function getDatenaiss()
    {
    	
    	/*if(is_long($this->datenaiss))
    	  
    	{
    	return date('d/m/Y',$this->datenaiss);
    	
    	}*/    	
    	 

    	return $this->datenaiss;
    }
    /**
     * setDatenaiss
     *
     * @param \string $d
     * @return \oeuvresBundle\Entity\Compositeurs
     */
    public function setDatenaiss($d)
    {
    	$this->datenaiss=$d;
    	return $this;
    }
    
    /**
     *
     */
    public function getDatedeces()
    {
    	/*if(is_long($this->datedeces))
    	  
    	{
    	return date('d/m/Y',$this->datedeces);
    	
    	}*/
    	return $this->datedeces;
    }
    /**
     * setDatedeces
     *
     * @param \string $d
     * @return \oeuvresBundle\Entity\Compositeurs
     */
    public function setDatedeces($d)
    {
    	$this->datedeces=$d;
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
    * @return \oeuvresBundle\Entity\Compositeurs
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
    	
		if(is_long($this->datecreateAt))
		    	{
			return date('d/m/Y',$this->datecreateAt);
			
		}
		return "";
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
