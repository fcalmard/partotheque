<?php 

namespace oeuvresBundle\Entity;


use Doctrine\ORM\Mapping as ORM;



/**
 * Logins
 *
 * @ORM\Table(name="Logins")
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\LoginsRepository")
 *
 */
class Logins
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
	 *@ORM\ManyToOne(targetEntity="Utilisateurs", inversedBy="Logins", cascade={"persist"})
	 */	
	private $Utilisateurs;
	
	/**
	 * @var \Login
	 *
	 * @ORM\Column(name="Login", type="string")
	 */	
	private $Login;
		
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
	public function getLogin()
	{
		return $this->Login;
	}
	/**
	 * 
	 * setLogin
	 * @param string $log
	 * @return Logins
	 */
	public function setLogin($log)
	{
		$this->Login=$log;
		return $this;
	}	

	/**
	 * setDatecreateAt
	 *
	 * @param \DateTime $datecreateAt
	 * @return Logins
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
	public function getUtilisateurs()
	{
		
		return $this->Utilisateurs;
	}
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->datecreateAt = new \DateTime('now');
		
		$this->Utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
		
	}

}