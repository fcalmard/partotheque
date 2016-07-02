<?php

namespace oeuvresBundle\Entity;

use Doctrine\DBAL\Types\FloatType;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Partitions
 *
 * @ORM\Table(name="Partitions",uniqueConstraints={@ORM\UniqueConstraint(name="id_idx", columns={"id"})})
 * @ORM\Entity(repositoryClass="mychorale\Bundle\oeuvresBundle\Repository\")
  * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\PartitionsRepository")

 * @UniqueEntity(fields={"libelle"}, message="Ce libelle existe déja")
 * 
 */
class Partitions
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, unique=true)
     */
    private $libelle;
        
    /**
     * @var integer
     * @ORM\Column(name="active", type="integer",nullable=false)
     *
     */
    private $active;
        
    /**
     * @ORM\Column(name="duree",type="float",nullable=true, scale=2,options={"default"= 0}))
     */
    private $duree;

    /**
     *
     * @var integer
     *
     * @ORM\Column(name="oeuvre_id", type="integer",nullable=false)
     *
     */
    private $oeuvre_id;
    
    
    /**
     *@ORM\ManyToOne(targetEntity="Oeuvres", inversedBy="Partitions", cascade={"persist"})
     */
    private $Oeuvres;
    /**
     *
     * @var string
     * @ORM\Column(name="pathfichier", type="string", length=512,nullable=true)
     */
    private $pathfichier;
    
    
    /**
     * @var string partitionFile
     * @Assert\File( maxSize = "1000000M", mimeTypesMessage = "format de fichier invalide",mimeTypes={"application/pdf"})
     * @ORM\Column(name="partitionFile", type="string", length=512,nullable=true)
     */
    protected $partitionFile;
    
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
    public function getOeuvreId()
    {
    	 return $this->oeuvre_id;
    }
    
    /**
     * 
     * @param integer $id
     * @return \oeuvresBundle\Entity\Partitions
     */
    public function setOeuvreId($id)
    {
    	 $this->oeuvre_id=$id;
    	 return $this;
    }
    
    
    public function getOeuvres()
    {
    	return $this->Oeuvres;
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
     * @return \oeuvresBundle\Entity\Partitions
     */
    public function setLibelle($l)
    {
    	$this->libelle=$l;
    	return $this;
    }
    
    public function setPartitionFile(File $file = null)
    {
    	$this->partitionFile = $file;
    	return $this;
    }
    
    public function getPartitionFile()
    {
    	return $this->partitionFile;
    }    
    
    /**
     * 
     */
    public function getPathfichier()
    {
    	 return $this->pathfichier;
    }
    /**
     * 
     * @param string $pathfichier
     * @return \oeuvresBundle\Entity\Partitions
     */
    public function setPathfichier($pathfichier)
    {
    	 $this->pathfichier=$pathfichier;
    	 return $this;
    }    
    /**
     * 
     */
    public function getDuree()
    {
    	return $this->duree;
    }
    /**
     * 
     * @param numeric $d
     * @return \oeuvresBundle\Entity\Partitions
     */
    public function setDuree($d)
    {
    	$this->duree=$d;
    	return $this;
    	 
    }
    /**

     */
    public function getHistorique()
    {
    	 return $this->historique;
    	 
    }
    /**
     * @param string $historique
     * @return \oeuvresBundle\Entity\Partitions
     */
    public function setHistorique($historique)
    {
    	 $this->historique=$historique;
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
     */
    public function setActive($a)
    {
    	$a=($a) ? 1 : 0;
    	$this->active=$a;
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
