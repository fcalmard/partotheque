<?php

namespace oeuvresBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;

/**
 * Utilisateurs
 *
 * @ORM\Table(name="Utilisateurs",uniqueConstraints={@ORM\UniqueConstraint(name="login_idx", columns={"Login"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\UtilisateursRepository")
 * @UniqueEntity(fields={"Login"}, message="Ce Compte utilisateur existe déja")
 * @UniqueEntity(fields={"email"}, message="Cet Email existe déja")
 */
class Utilisateurs
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
     * @ORM\Column(name="Login", type="string", length=30)
     */
    private $Login;

    /**
     * @var string
     *
     * @ORM\Column(name="Passwd", type="string", length=255)
     */
    private $passwd;

    /**
     *
     * @ORM\OneToMany(targetEntity="Logins", mappedBy="Utilisateurs", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $Logins;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=255, nullable=true)
     */
    private $prenom; 
    
	/**
	 * @var string
	 *
	 * @ORM\Column(name="Email", type="string", length=255, nullable=false)
	 */
    private $email;  
    
    /**
     *
     * @var Profils_id
     *
     * @ORM\Column(name="Profils_id", type="integer",nullable=false)
     *
     */    
    private $Profils_id;
    
    /**
     * @var boolean
     * @ORM\Column(name="actif", type="boolean")
     */    
    private $actif;
    
    /**
     * @var integer
     * @ORM\Column(name="idPays", type="integer")
     * @ORM\OneToOne(targetEntity="Pays", inversedBy="Utilisateurs", )
     * @ORM\JoinColumn(name="idPays", referencedColumnName="id", nullable=true)
     */
    private $idPays;
        
    /**
    * @var dateTime
    * 
    * @ORM\Column(name="datecreateAt", type="datetime")
    */
    private $datecreateAt;    

    public function __construct()
    {
    	$this->datecreateAt = new \DateTime('now');
    	$this->Logins = new ArrayCollection();    	
    	$this->idPays=0;
    }    
    public function __toString()
    {
    	return strval($this->id);
    }
    
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
     * Set login
     *
     * @param string $login
     * @return Utilisateurs
     */
    public function setLogin($login)
    {
        $this->Login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->Login;
    }

    /**
     * Set passwd
     *
     * @param string $passwd
     * @return Utilisateurs
     */
    public function setPasswd($passwd)
    {
        $this->passwd = md5($passwd);

        return $this;
    }

    /**
     * Get passwd
     *
     * @return string 
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Utilisateurs
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Utilisateurs
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * 
     * @param string $e
     */
    public function setEmail($e)
    {
    	$this->email=$e;
    	return $this;
    }
    /**
     * @return string;
     */
    public function getEmail()
    {
    	return $this->email;
    }
    
    /**
     * 
     */
    public function getProfilsId()
    {
    	return $this->Profils_id;
    }
    /**
     * 
     * @param integer $i
     */
    public function setProfilsId($i)
    {
    	$this->Profils_id=$i;
    	return $this;
    }    
     /**
     * Set datecreateAt
     *
     * @param \DateTime $datecreateAt
     * @return Utilisateurs
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
    
    public function getActif()
    {
    	return $this->actif;
    }
    
    public function setActif($bActif)
    {
    	$this->actif=$bActif;
    	return $this;
    }
    
    /**
     * 
     * @return number
     */
    public function getIdPays()
    {
    	return $this->idPays;
    }
    /**
     * 
     * @param integer $i
     */
    public function setIdPays($i)
    {
    	$this->idPays=$i;
    	return $this;
    }    


}
