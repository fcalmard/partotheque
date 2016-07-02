<?php

namespace oeuvresBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;

/**
 * Accompagnements
 *
 * @ORM\Table(name="Accompagnements",uniqueConstraints={@ORM\UniqueConstraint(name="typeaccLibelle_idx", columns={"libelle"})}) 
 * @ORM\Entity(repositoryClass="oeuvresBundle\Repository\AccompagnementsRepository")
 * @UniqueEntity(fields={"libelle"}, message="Ce Type d' Accompagnement existe déja")
 *  
 */
class Accompagnements
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

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
     * Set active
     *
     * @param integer $active
     *
     * @return Accompagnements
     */
    public function setActive($active)
    {
        $this->active = ($active==1);

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return ($this->active==1);
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Accompagnements
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set datecreateAt
     *
     * @param \DateTime $datecreateAt
     *
     * @return Accompagnements
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
}

