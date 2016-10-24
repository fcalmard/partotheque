<?php 

namespace oeuvresBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

//use Doctrine\ORM\Persisters\ManyToManyPersister;
//Doctrine\ORM\PersistentCollection implements Doctrine\Common\Collections\Collection
use Doctrine\ORM\PersistentCollection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;

use Symfony\Component\Yaml\Yaml;
use oeuvresBundle\Repository\MenusRepository;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\inverseJoinColumn;
use Doctrine\ORM\Mapping\inverseJoinColumns;

/**
 * Menus
 * 
 * @ORM\Table(name="Menus",uniqueConstraints={@ORM\UniqueConstraint(name="code_menu_idx", columns={"code_menu"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\MenusRepository")
 * @UniqueEntity(fields={"codeMenu"}, message="Ce code menu existe déja")
 */

class Menus
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
	 * @ORM\Column(name="code_menu", type="string", length=10)
	 */
	private  $codeMenu;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="libelle_menu", type="string", length=255, unique=true)
	 */
	private $libelleMenu;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="lnk", type="string", length=255,unique=false)
	 *
	 */
	private $lnk;


	/**
	 * @var integer
	 *
	 * @ORM\ManyToMany(targetEntity="Profils")
	 * ,joinColumns={@JoinColumn(name="menus_id", referencedColumnName="id")}
	 * ,inverseJoinColumns={@JoinColumn(name="profils_id", referencedColumnName="id")}
	 * )
	 */
	private $Profils;

	/**
	 * @var dateTime
	 *
	 * @ORM\Column(name="datecreateAt", type="datetime")
	 */
	private $datecreateAt;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="actif", type="boolean")
	 *
	 */
	private $actif;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="bo_home", type="boolean")
	 *
	 */
	private $bo_home;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="affdansmenu", type="boolean")
	 *
	 */
	private $affdansmenu;
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="affdansbo", type="boolean")
	 *
	 */
	private $affdansbo;

	/**
	 *
	 * @var integer
	 *
	 * @ORM\Column(name="ordreaff", type="integer")
	 *
	 */
	private $ordreaff;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="tooltip", type="string", length=255, nullable=true)
	 */
	private $tooltip;

	/**
	 * @var integer $id_mensup
	 * @ORM\OneToOne(targetEntity="oeuvresBundle\Entity\Menus")
	 * @ORM\Column(name="id_mensup", type="integer", nullable=true)
	 */
	private $id_mensup;

	/**
	 * @var string
	 *
	 * si rempli formulaire affiché au lieu de la liste habiuelle
	 *
	 *
	 * @ORM\Column(name="formaff", type="string", length=255)
	 */
	private $formaff;

	public $libmr;


	/**
	 *
	 * @var \String

	 * @ORM\Column(name="ImageBo", type="string", nullable=true)
	 */
	private $ImageBo;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->datecreateAt = new \DateTime('now');

		$this->Profils = new \Doctrine\Common\Collections\ArrayCollection();
		
		$this->actif=true;
		$this->bo_home=false;
		$this->ordreaff=0;
		$this->lnk='#';
		$this->id_mensup=0;
		$this->affdansbo=false;
		$this->affdansmenu=true;
		 
		/*
		 * si rempli formulaire affiché au lieu de la liste habiuelle
		*
		*/
		$this->formaff="";
		 
		 
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
	 * Set codeMenu
	 *
	 * @param string $codeMenu
	 * @return Menus
	 */
	public function setCodeMenu($codeMenu)
	{
		$this->codeMenu = $codeMenu;

		return $this;
	}

	/**
	 * Get codeMenu
	 *
	 * @return string
	 */
	public function getCodeMenu()
	{
		return $this->codeMenu;
	}

	/**
	 * Set libelleMenu
	 *
	 * @param string $libelleMenu
	 * @return Menus
	 */
	public function setLibelleMenu($libelleMenu)
	{
		$this->libelleMenu = $libelleMenu;

		return $this;
	}

	/**
	 * Get libelleMenu
	 *
	 * @return string
	 */
	public function getLibelleMenu()
	{
		return $this->libelleMenu;
	}

	/**
	 *
	 */
	public function getFormaff()
	{
		return $this->formaff;
	}
	/**
	 *
	 * @param string $s
	 */
	public function setFormaff($s)
	{
		$this->formaff=$s;
		return $this;
	}

	/**
	 *
	 * @param string $sLnk
	 * @return Menus
	 *
	 */
	public function setLnk($sLnk)
	{
		$this->lnk=$sLnk;
		return $this;
	}
	/**
	 *
	 */
	public function getLnk()
	{
		return $this->lnk;
	}

	/**
	 * Add Profil
	 *
	 * @param \mychorale\Bundle\MainBundle\Entity\Profils $profil
	 * @return Menus
	 */
	public function addProfil(oeuvresBundle\Entity\Profils $profil)
	{
		// Si l'objet fait déjà partie de la collection on ne l'ajoute pas
		if (!$this->Profils->contains($profil)) {
			if (!$profil->getMenus()->contains($this)) {
				$profil->addMenu($this);  // Lie le PROFIL au MENU
			}
			$this->Profils->add($profil);
		}
		return $this;
	}

	/**
	 * Remove Profil
	 * @param \mychorale\Bundle\MainBundle\Entity\Profils $profil
	 */
	public function removeProfil(\mychorale\Bundle\MainBundle\Entity\Profils $profil)
	{
		$this->profils->removeElement($profil);
	}


	/**
	 * Get Profils
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getProfils()
	{
		return $this->Profils;
	}

	/**
	 * @param \mychorale\Bundle\MainBundle\Entity\Profils $profil
	 */
	public function setProfils(\mychorale\Bundle\MainBundle\Entity\Profils $profil)
	{
		return $this;
	}

	/**
	 *
	 */
	public function setProfils_id($id)
	{
		$this->profils_id=$id;
		return $this;
	}
	/**
	 *
	 */
	public function getProfils_id()
	{
		return $this->profils_id;
	}

	/**
	 *
	 */
	public function setAffdansmenu($affdsmenu)
	{
		$this->affdansmenu=$affdsmenu;
		return $this;
	}
	/**
	 *
	 */
	public function getAffdansmenu()
	{
		return $this->affdansmenu;
	}


	/**
	 *bo_home
	 */
	public function setBoHome($b)
	{
		$this->bo_home=$b;
		return $this;
	}
	/**
	 *
	 */
	public function getBoHome()
	{
		return $this->bo_home;
	}


	/**
	 *
	 */
	public function setAffdansbo($affdansbo)
	{
		$this->affdansbo=$affdansbo;
		return $this;
	}
	/**
	 *
	 */
	public function getAffdansbo()
	{
		return $this->affdansbo;
	}

	/**
	 *
	 */
	public function setActif($actif)
	{
		$this->actif=$actif;
		return $this;
	}
	/**
	 *
	 */
	public function getActif()
	{
		return $this->actif;
	}

	/**
	 *
	 */
	public function getOrdreaff()
	{
		return $this->ordreaff;
	}
	public function setOrdreaff($ordreaff)
	{
		$this->ordreaff=$ordreaff;
		return $this;
	}
	/**
	 *
	 */
	public function getTooltip()
	{
		return $this->tooltip;
	}
	public function setTooltip($tooltip)
	{
		$this->tooltip=$tooltip;
		return $this;
	}
	/**
	 *
	 */
	public function getIdMensup()
	{
		return $this->id_mensup;
		 
	}
	public function setIdMensup($id_mensup)
	{
		$this->id_mensup=$id_mensup;
		return $this;
	}

	/**
	 * image pour barre outils
	 */
	public function getImageBo()
	{
		return $this->ImageBo;
	}
	public function setImageBo($sPathImage)
	{
		$this->ImageBo=$sPathImage;
		return $this;

	}

	/**
	 * default_imagebo_menu
	 */
	public function getDefaultImageBo()
	{
		$sDefaultImage='';
		$config='/var/www/sites/mychorale/src/mychorale/Bundle/MainBundle/Resources/config/myconfig.yml';
		if(file_exists($config))
		{
			$config1 = Yaml::parse($config);
			$sDefaultImage = $config1['parameters']['default_imagebo_menu'];
		}
		return $sDefaultImage;
	}
	//
	public function getWeb_path_imagebo_menu()
	{
		$sWeb_path='';
		$config='/var/www/sites/mychorale/src/mychorale/Bundle/MainBundle/Resources/config/myconfig.yml';
		if(file_exists($config))
		{
			$config1 = Yaml::parse($config);
			$sWeb_path = $config1['parameters']['web_path_imagebo_menu'];
		}
		return $sWeb_path;
	}
	/**
	 *
	 */
	public function getPathCible()
	{
		$sPathCible='/var/www/sites/mychorale/web/UsersRessouces/Images';
		$config='/var/www/sites/mychorale/src/mychorale/Bundle/MainBundle/Resources/config/myconfig.yml';
		if(file_exists($config))
		{
			$config1 = Yaml::parse($config);
			$sPathCible = $config1['parameters']['path_imagebo_menu'];
		}
		return $sPathCible;
	}
	 
	//.' '.$this->libelle_menu
	public function __toString()
	{
		return strval($this->id);
	}
	
	public function getDatecreateAt()
	{
		return $this->datecreateAt;
	}
}