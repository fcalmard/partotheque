<?php 
namespace oeuvresBundle\Entity;
use Doctrine\ORM\PersistentCollection;

use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\inverseJoinColumn;
use Doctrine\ORM\Mapping\inverseJoinColumns;

use Symfony\Component\Translation\Tests\String;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
	
use Doctrine\ORM\Persisters\ManyToManyPersister;
//Doctrine\ORM\PersistentCollection implements Doctrine\Common\Collections\Collection
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;

use oeuvresBundle\Repository\MenusRepository;

use Symfony\Component\Yaml\Yaml;

/**
 * Profils
 *
 * @ORM\Table(name="Profils",uniqueConstraints={@ORM\UniqueConstraint(name="CodeProfil_idx", columns={"CodeProfil"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\ProfilsRepository")
 * @UniqueEntity(fields={"CodeProfil"}, message="Ce Profil existe déja")
 *
 */
class Profils
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
	 * @ORM\Column(name="CodeProfil", type="string", length=10, unique=true)
	 */
	private $CodeProfil;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="LibelleProfil", type="string", length=255, unique=true)
	 */
	private $libelleProfil;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="datecreateAt", type="datetime")
	 */
	private $datecreateAt;
	/**
	 *
	 * @ORM\ManyToMany(targetEntity="Menus")
	 * @JoinTable(name="profils_menus"
	 * ,joinColumns={@JoinColumn(name="profils_id", referencedColumnName="id")}
	 * ,inverseJoinColumns={@JoinColumn(name="menus_id", referencedColumnName="id")}
	 * )
 	 * 
	 */
	protected $Menus;
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="actif", type="smallint")
	 *
	 */
	private $actif;

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
	 * Set codeProfil
	 *
	 * @param string $codeProfil
	 * @return Profils
	 */
	public function setCodeProfil($codeProfil)
	{
		$this->CodeProfil = $codeProfil;

		return $this;
	}

	/**
	 * Get codeProfil
	 *
	 * @return string
	 */
	public function getCodeProfil()
	{
		return $this->CodeProfil;
	}

	/**
	 * Set libelleProfil
	 *
	 * @param string $libelleProfil
	 * @return Profils
	 */
	public function setLibelleProfil($libelleProfil)
	{
		$this->libelleProfil = $libelleProfil;

		return $this;
	}

	/**
	 * Get libelleProfil
	 *
	 * @return string
	 */
	public function getLibelleProfil()
	{
		return $this->libelleProfil;
	}

	/**
	 * Set datecreateAt
	 *
	 * @param \DateTime $datecreateAt
	 * @return Profils
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
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->datecreateAt = new \DateTime('now');
		
		$this->actif=true;
		
		$this->Menus = new \Doctrine\Common\Collections\ArrayCollection();
		
	}

	/**
	 * 
	 */
	public function getMenus()
	{
		return $this->Menus;
	}
	
	/**
	 * Add Menus
	 *
	 * @param oeuvresBundle\Entity\Menus $menu
	 * @return Profils
	 */
	public function addMenu($menu)
	{		
		// Si l'objet fait déjà partie de la collection on ne l'ajoute pas
		if (!$this->Menus->contains($menu)) {
			if (!$menu->getProfils()->contains($this)) {
				$profil->addProfil($this);  // Lie le PROFIL au MENU
			}
			$this->Menus->add($menu);
			
		}
		return $this;
	}
	
	/**
	 * Remove Menus
	 *
	 * @param oeuvresBundle\Entity\Menus $menu
	 */
	public function removeMenu(oeuvresBundle\Entity\Menus $menu)
	{
		$this->Menus->removeElement($menu);
	}
		
	
	/**
	 *
	 * @param unknown_type $actif
	 */
	public function setActif($actif)
	{
		$this->actif = ($actif==1);
		
		return $this;
	}

	/**
	 *
	 *
	 */
	public function getActif()
	{
        return ($this->actif==1);
	}

	public function __toString()
	{
		return strval($this->id);
	}

}