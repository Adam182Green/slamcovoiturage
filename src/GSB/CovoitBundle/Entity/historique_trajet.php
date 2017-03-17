<?php

namespace GSB\CovoitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * historique_trajet
 *
 * @ORM\Table(name="historique_trajet")
 * @ORM\Entity(repositoryClass="GSB\CovoitBundle\Repository\historique_trajetRepository")
 */
class historique_trajet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="GSB\CovoitBundle\Entity\Salarie", cascade={"persist"})
     * @ORM\JoinColumn(name="auteur_id", referencedColumnName="id")
     */
    private $auteurId;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="GSB\CovoitBundle\Entity\Ville", cascade={"persist"})
     * @ORM\JoinColumn(name="id_ville", referencedColumnName="id")
     */
    private $idVille;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="GSB\CovoitBundle\Entity\TypeVehicule", cascade={"persist"})
     * @ORM\JoinColumn(name="id_type_vehicule", referencedColumnName="id")
     */
    private $idTypeVehicule;

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
     * @var bool
     *
     * @ORM\Column(name="aller_ou_retour", type="boolean")
     */
    private $allerOuRetour;

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
     * @return historique_trajet
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
     * Set idVille
     *
     * @param integer $idVille
     *
     * @return historique_trajet
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
     * Set idTypeVehicule
     *
     * @param integer $idTypeVehicule
     *
     * @return historique_trajet
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
     * Set dateTrajet
     *
     * @param \DateTime $dateTrajet
     *
     * @return historique_trajet
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
     * @return historique_trajet
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
     * Set allerOuRetour
     *
     * @param boolean $allerOuRetour
     *
     * @return historique_trajet
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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return historique_trajet
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

