<?php 

namespace oeuvresBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;

/**
 * Tessitures
 *
 * @ORM\Table(name="Tessitures",uniqueConstraints={@ORM\UniqueConstraint(name="CodeTessiture_idx", columns={"CodeTessiture"})})
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\TessituresRepository")
 * @UniqueEntity(fields={"CodeTessiture"}, message="Cette tessiture existe déja")
 *
 */
class Tessitures
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
	 * @ORM\Column(name="CodeTessiture", type="string", length=10, unique=true)
	 */
	private $CodeTessiture;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="libelleTessiture", type="string", length=255, unique=true)
	 */
	private $libelleTessiture;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="datecreateAt", type="datetime")
	 */
	private $datecreateAt;
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
	 * Set codeTessiture
	 *
	 * @param string $codeTessiture
	 * @return Tessitures
	 */
	public function setCodeTessiture($codeTessiture)
	{
		$this->CodeTessiture= $codeTessiture;

		return $this;
	}

	/**
	 * Get codeTessiture
	 *
	 * @return string
	 */
	public function getCodeTessiture()
	{
		return $this->CodeTessiture;
	}

	/**
	 * Set libelleTessiture
	 *
	 * @param string $libelleTessiture
	 * @return Tessitures
	 */
	public function setLibelleTessiture($libelleTessiture)
	{
		$this->libelleTessiture = $libelleTessiture;

		return $this;
	}

	/**
	 * Get libelleTessiture
	 *
	 * @return string
	 */
	public function getLibelleTessiture()
	{
		return $this->libelleTessiture;
	}

	/**
	 * Set datecreateAt
	 *
	 * @param \DateTime $datecreateAt
	 * @return Tessitures
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
	 * @return boolean
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