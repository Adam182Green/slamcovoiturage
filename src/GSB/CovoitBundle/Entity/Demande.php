<?php

namespace GSB\CovoitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demande
 *
 * @ORM\Table(name="demande")
 * @ORM\Entity(repositoryClass="GSB\CovoitBundle\Repository\DemandeRepository")
 */
class Demande
{
    /**
     * @var int
     *
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="GSB\CovoitBundle\Entity\Trajet")
     * @ORM\JoinColumn(name="trajet_id", referencedColumnName="id")
     */
    private $trajetId;

    /**
     * @var int
     *
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="GSB\CovoitBundle\Entity\Salarie")
     * @ORM\JoinColumn(name="salarie_id", referencedColumnName="id")
     */
    private $salarieId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_demande", type="date")
     */
    private $dateDemande;

    /**
     * @var bool
     *
     * @ORM\Column(name="validee", type="boolean")
     */
    private $validee;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set trajetId
     *
     * @param integer $trajetId
     *
     * @return Demande
     */
    public function setTrajetId($trajetId)
    {
        $this->trajetId = $trajetId;

        return $this;
    }

    /**
     * Get trajetId
     *
     * @return int
     */
    public function getTrajetId()
    {
        return $this->trajetId;
    }

    /**
     * Set salarieId
     *
     * @param integer $salarieId
     *
     * @return Demande
     */
    public function setSalarieId($salarieId)
    {
        $this->salarieId = $salarieId;

        return $this;
    }

    /**
     * Get salarieId
     *
     * @return int
     */
    public function getSalarieId()
    {
        return $this->salarieId;
    }

    /**
     * Set dateDemande
     *
     * @param \DateTime $dateDemande
     *
     * @return Demande
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    /**
     * Get dateDemande
     *
     * @return \DateTime
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

    /**
     * Set validee
     *
     * @param boolean $validee
     *
     * @return Demande
     */
    public function setValidee($validee)
    {
        $this->validee = $validee;

        return $this;
    }

    /**
     * Get validee
     *
     * @return bool
     */
    public function getValidee()
    {
        return $this->validee;
    }
}
