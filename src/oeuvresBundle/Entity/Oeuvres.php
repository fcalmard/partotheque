<?php

namespace oeuvresBundle\Entity;

use Doctrine\DBAL\Types\FloatType;

use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToOne;
/*
use oeuvresBundle\Repository\OeuvresRepository;
use oeuvresBundle\Repository\TempsLiturgiquesRepository;
*/
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

use Symfony\Component\Translation\Tests\String;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\inverseJoinColumn;
use Doctrine\ORM\Mapping\inverseJoinColumns;

//use Compositeurs;
use oeuvresBundle\Repository\CompositeursRepository;

/**
 * Oeuvres
 *
 * @ORM\Table(name="Oeuvres",uniqueConstraints={@ORM\UniqueConstraint(name="titreOeuvre_idx", columns={"titreOeuvre"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\OeuvresRepository")
 * @UniqueEntity(fields={"titreOeuvre"}, message="Cette oeuvre existe déja")
 * 
 */
class Oeuvres
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
     * @ORM\Column(name="actif", type="boolean",nullable=true)
     */
    private $actif;
    /**
     *
     * @var integer
      
     * @ORM\Column(name="anonyme", type="boolean",nullable=true)
     *
     */
    private $anonyme;
        
    /**
     * @var string
     *
     * @ORM\Column(name="titreOeuvre", type="string", length=128, unique=true)
     */
    private $titreOeuvre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="traductiontitreOeuvre", type="string", length=128, unique=false,nullable=true)
     */
    private $traductiontitreOeuvre;
    
    /**
     * @var string traductionfile
     * @Assert\File( maxSize = "10000000000M", mimeTypesMessage = "format de fichier invalide",mimeTypes={"application/pdf"})
     * @ORM\Column(name="traductionfile", type="string", length=512,nullable=true)
     */
    protected $traductionfile;    
    
    /**
     *
     * @var fichiertraduction
     *
     * @ORM\Column(name="fichiertraduction", type="string",nullable=true)
     *
     */
    private $fichiertraduction;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Partitions", mappedBy="Oeuvres", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * 
     */
    private $Partitions;
    
    /**
     *
     * @var tps_litur_id
     *
     * @ORM\Column(name="tps_litur_id", type="integer",nullable=true)
     *
     */
    private $tps_litur_id;
        
    /**
     *
     * @var compositeur_id
     *
     * @ORM\Column(name="compositeur_id", type="integer",nullable=true)
     *
     */
    private $compositeur_id;
       
    /**
     *
     * @var integer
     *
     * @ORM\Column(name="fonction_id", type="integer",nullable=true)
     *
     */
    private $fonction_id;
    
    /**
     *
     * @var integer
     *
     * @ORM\Column(name="accompagnement_id", type="integer",nullable=true)
     *
     */
    private $accompagnement_id;
        
	/**
	 * 
	 * @var String
	 * @ORM\Column(name="cote", type="string", length=20, unique=false,nullable=true)
	 * 
	 */
    private $cote;
    
    /**
     *
     * @var integer
     *
     * @ORM\Column(name="voix_id", type="integer",nullable=true)
     *
     */
    private $voix_id;
    
    /**
     * @ORM\Column(name="duree",type="float",nullable=true, scale=2,options={"default"= 0}))
     * egale somme de la duree des partitions
     */
    private $duree;
    
    /**
     *
     * @var integer
     *
     * @ORM\Column(name="genre_id", type="integer",nullable=true)
     *
     */    
    private $genre_id;
    
    /**
     *
     * @var integer
     *
     * @ORM\Column(name="avancement_id", type="integer",nullable=true)
     *
     */
    private $avancement_id;
    
    /**
     *
     * @var String
     * @ORM\Column(name="siecle", type="string", length=10, unique=false,nullable=true)
     *
     */
    private $siecle;
    
    /**
     * @var String
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;
    
    /**
     *
     * @var String
     * @ORM\Column(name="reference", type="string", length=100, unique=false)
     *
     */    
    private $reference;
    
    /**
     * @var integer
     *
     * @ORM\ManyToMany(targetEntity="Langues")
     * ,joinColumns={@JoinColumn(name="oeuvres_id", referencedColumnName="id")}
     * ,inverseJoinColumns={@JoinColumn(name="langues_id", referencedColumnName="id")}
     * )
     */
    private $Langues;    
    
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
    public function getAnonyme()
    {
    	return $this->anonyme==1;
    }
    /**
     * 
     * @param integer $a
     * @return \oeuvresBundle\Entity\Oeuvres
     */
    public function setAnonyme($a)
    {
    	
    	$a=($a) ? 1 : 0;
    	$this->anonyme=$a;
    	//var_dump($a);
    	//die('setAnonyme');
    	return $this;
    }
    
    public function getPartitions()
    {
    	return $this->Partitions;
    }
    /**
     *
     */
    public function getActif()
    {
    	return $this->actif==1;
    }
    
    /**
     *
     * @param integer $a
     */
    public function setActif($a)
    {
    	$a=($a) ? 1 : 0;
    	 
    	$this->actif=$a;
    	
    	//var_dump($a);
    	//die('setActive');
    	    	
    	return $this;
    }    

    /**
     * 
     * @param integer $id
     */
    public function setCompositeurId($id)
    {
    	$this->compositeur_id=$id;
        return $this;
    }
    /**
     * 
     */
    public function getCompositeurId()
    {
    	return $this->compositeur_id;
    }    
    
    public function getCompositeurOeuvre()
    {
    	return $this->compositeur_id;
    	 
    }
    /**
     * 
     * @param integer $id
     * @return \oeuvresBundle\Entity\Oeuvres
     */
    public function setAccompagnementId($id)
    {
    	$this->accompagnement_id=$id;
    	return $this;
    	 
    }
    public function getAccompagnementId()
    {
    	return $this->accompagnement_id;
    }    
    
    public function getDuree()
    {
    	$d=$this->duree;
    	$d=floatval($d);
    	return $d;
    }
    /**
     * 
     * @param FloatType $d
     */
    public function setDuree($d)
    {
    	$d=floatval($d);
    	$this->duree=$d;
    	
    	return $this;
    }
    
    /**
     *getTpsLiturId
     */
    public function getTpsLiturId()
    {
    	return $this->tps_litur_id;
    }
    
    /**
     * setTpsLiturId
     * @param integer $id
     * @return \oeuvresBundle\Entity\Oeuvres
     */
    public function setTpsLiturId($id)
    {
    	$this->tps_litur_id=$id;    	
    	return $this;
    }

    /**
     *
     */
    public function getFonctionId()
    {
    	return $this->fonction_id;
    }
    /**
     *
     * @param integer $id
     * @return \oeuvresBundle\Entity\Oeuvres
     */
    public function setFonctionId($id)
    {
    	$this->fonction_id=$id;
    	return $this;
    }
       
    /**
     *
     */
    public function getAvancementId()
    {
    	return $this->avancement_id;
    }
    /**
     *
     * @param integer $id
     * @return \oeuvresBundle\Entity\Oeuvres
     */
    public function setAvancementId($id)
    {
    	$this->avancement_id=$id;
    	return $this;
    }
    
    /**
     * 
     */
    public function getCote()
    {
    	return $this->cote;
    }
    /**
     * 
     * @param string $cote
     * @return \oeuvresBundle\Entity\Oeuvres
     */
    public function setCote($cote)
    {
    	$this->cote=$cote;
    	return $this;
    }
    
    /**
     * 
     */
    public function getVoixId()
    {
    	 return $this->voix_id;
    }
    /**
     * 
     * @param integer $id
     * @return \oeuvresBundle\Entity\Oeuvres
     */
    public function setVoixId($id)
    {
    	$this->voix_id=$id;
    	return $this;
    }    
    /**
     * return string
     */
    public function getGenreId()
    {
    	 return $this->genre_id;
    }
    /**
     *
     * @param integer $id
     * @return \oeuvresBundle\Entity\Oeuvres
     */    
    public function setGenreId($id)
    {
    	$this->genre_id=$id; 
    	return $this;
    }
        
    /**
     * 
     */
    public function getSiecle()
    {
    	 return $this->siecle;
    }
    
    
    /**
     * 
     * @param string $siecle
     * @return \oeuvresBundle\Entity\Oeuvres
     */
    public function setSiecle($siecle)
    {
    	 $this->siecle=$siecle;
    	 return $this;
    }
    
	/**
	 * 
	 */
    public function getCommentaire()
    {
    	 return $this->commentaire;
    }

    /**
     * 
     * @param string $c
     * @return \oeuvresBundle\Entity\Oeuvres
     */
    public function setCommentaire($c)
    {
    	$this->commentaire=$c;
    	return $this;
    }
        
    /**
     * 
     */
    public function getReference()
    {
    	 return $this->reference;
    }
    /**
     * 
     * @param string $reference
     * @return \oeuvresBundle\Entity\Oeuvres
     */
    public function setReference($reference)
    {
    	 $this->reference=$reference;
    	 return $this;
    }
        
    /**
     *
     */
    public function getTitreoeuvre()
    {
    	return $this->titreOeuvre;
    }
    /**
     *
     * @param string $titre
     * @return Oeuvres
     *
     */
    public function setTitreoeuvre($titre)
    {
    	$this->titreOeuvre=$titre;
    	return $this;
    }

    /**
     * 
     */
    /**
     *
     */
    public function getTraductiontitreOeuvre()
    {
    	return $this->traductiontitreOeuvre;
    }
    /**
     *
     * @param string $titre
     * @return Oeuvres
     *
     */
    public function setTraductiontitreOeuvre($titre)
    {
    	$this->traductiontitreOeuvre=$titre;
    	return $this;
    }
    

    public function getTraductionfile()
    {
    	return $this->traductionfile;
    	 
    }
    /**
     * 
     * @param string $s
     * @return Oeuvres
     * 
     */
    public function setTraductionfile($s)
    {

    	$this->traductionfile=$s;
    	return $this;
    	 
    }
    
    /**
     * 
     */
    public function getFichiertraduction()
    {
    	return $this->fichiertraduction;
    }
    /**
     * 
     * @param string $f
     */
    public function setFichiertraduction($f)
    {
    	$this->fichiertraduction=$f;
    	return $this;
    }
    
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
    	$this->file = $file;
    	// check if we have an old image path
    	if (is_file($this->getAbsolutePath())) {
    		// store the old name to delete after the update
    		$this->temp = $this->getAbsolutePath();
    	} else {
    		$this->path = 'initial';
    	}
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
    	if (null !== $this->getFile()) {
    		$this->path = $this->getFile()->guessExtension();
    	}
    }    
    
    public function getAbsolutePath()
    {
    	return null === $this->path
    	? null
    	: $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;
    }

    
    /**
     *
     */
    public function getLangues()
    {
    	return $this->Langues;
    }
    
    /**
     * Add Langues
     *
     * @param oeuvresBundle\Entity\Langues $langue
     * @return Profils
     */
    public function addLangue($langue)
    {
    	// Si l'objet fait déjà partie de la collection on ne l'ajoute pas
    	if (!$this->Langues->contains($langue)) {
    		if (!$langue->getOeuvres()->contains($this)) {
    			$langue->addOeuvres($this);  // Lie OEUVRE a la LANGUE
    		}
    		$this->Langues->add($langue);
    			
    	}
    	return $this;
    }
    
    /**
     * Remove Langues
     *
     * @param oeuvresBundle\Entity\Langues $langue
     */
    public function removeLangue(oeuvresBundle\Entity\Langues $langue)
    {
    	$this->Langues->removeElement($langue);
    }
    
    /**
     * Set datecreateAt
     *
     * @param \DateTime $datecreateAt
     * @return Oeuvres
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

        $this->Partitions = new ArrayCollection();
        
        $this->Langues = new \Doctrine\Common\Collections\ArrayCollection();
        
        
        //$this->duree=0;//somme des durees des partitions
    }
    
    
}
