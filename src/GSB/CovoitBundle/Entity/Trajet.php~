<?php

namespace GSB\CovoitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trajet
 *
 * @ORM\Table(name="trajet")
 * @ORM\Entity(repositoryClass="GSB\CovoitBundle\Repository\TrajetRepository")
 */
class Trajet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="GSB\CovoitBundle\Entity\Salarie")
     * @ORM\JoinColumn(name="auteur_id", referencedColumnName="id")
     */
    private $auteurId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_trajet", type="date")
     */
    private $dateTrajet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure_trajet", type="datetime")
     */
    private $heureTrajet;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="GSB\CovoitBundle\Entity\Ville")
     * @ORM\JoinColumn(name="id_ville", referencedColumnName="id")
     */
    private $idVille;

    /**
     * @var bool
     *
     * @ORM\Column(name="aller_ou_retour", type="boolean")
     */
    private $allerOuRetour;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="GSB\CovoitBundle\Entity\TypeVehicule")
     * @ORM\JoinColumn(name="id_type_vehicule", referencedColumnName="id")
     */
    private $idTypeVehicule;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255)
     */
    private $commentaire;


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
     * Set auteurId
     *
     * @param integer $auteurId
     *
     * @return Trajet
     */
    public function setAuteurId($auteurId)
    {
        $this->auteurId = $auteurId;

        return $this;
    }

    /**
     * Get auteurId
     *
     * @return int
     */
    public function getAuteurId()
    {
        return $this->auteurId;
    }

    /**
     * Set dateTrajet
     *
     * @param \DateTime $dateTrajet
     *
     * @return Trajet
     */
    public function setDateTrajet($dateTrajet)
    {
        $this->dateTrajet = $dateTrajet;

        return $this;
    }

    /**
     * Get dateTrajet
     *
     * @return \DateTime
     */
    public function getDateTrajet()
    {
        return $this->dateTrajet;
    }

    /**
     * Set heureTrajet
     *
     * @param \DateTime $heureTrajet
     *
     * @return Trajet
     */
    public function setHeureTrajet($heureTrajet)
    {
        $this->heureTrajet = $heureTrajet;

        return $this;
    }

    /**
     * Get heureTrajet
     *
     * @return \DateTime
     */
    public function getHeureTrajet()
    {
        return $this->heureTrajet;
    }

    /**
     * Set idVille
     *
     * @param integer $idVille
     *
     * @return Trajet
     */
    public function setIdVille($idVille)
    {
        $this->idVille = $idVille;

        return $this;
    }

    /**
     * Get idVille
     *
     * @return int
     */
    public function getIdVille()
    {
        return $this->idVille;
    }

    /**
     * Set allerOuRetour
     *
     * @param boolean $allerOuRetour
     *
     * @return Trajet
     */
    public function setAllerOuRetour($allerOuRetour)
    {
        $this->allerOuRetour = $allerOuRetour;

        return $this;
    }

    /**
     * Get allerOuRetour
     *
     * @return bool
     */
    public function getAllerOuRetour()
    {
        return $this->allerOuRetour;
    }

    /**
     * Set idTypeVehicule
     *
     * @param integer $idTypeVehicule
     *
     * @return Trajet
     */
    public function setIdTypeVehicule($idTypeVehicule)
    {
        $this->idTypeVehicule = $idTypeVehicule;

        return $this;
    }

    /**
     * Get idTypeVehicule
     *
     * @return int
     */
    public function getIdTypeVehicule()
    {
        return $this->idTypeVehicule;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Trajet
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}
