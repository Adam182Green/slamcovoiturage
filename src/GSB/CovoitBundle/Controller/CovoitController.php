<?php

namespace GSB\CovoitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CovoitController extends Controller
{
    public function indexAction()
    {
      // en attedant de récupérer en bdd
      $listAnnonces = array(
        array(
        'id'      => 1,
        'auteur'  => "Jean Tissipe",
        'date_trajet'    => new \Datetime(),
        'heure_trajet'   => new \Datetime(),
        'ville'       => "Arpajon-sur-Cère",
        'aller_ou_retour' => true,
        'type_vehicule' => "4x4",
        'commentaire'    => "Détour possible."),
      array(
        'id'      => 1,
        'auteur'  => "Marc Assain",
        'date_trajet'    => new \Datetime(),
        'heure_trajet'   => new \Datetime(),
        'ville'       => "Saint-Simon",
        'aller_ou_retour' => false,
        'type_vehicule' => "Berline",
        'commentaire'    => "Je fais mon premier covoiturage"),
      array(
        'id'      => 1,
        'auteur'  => "Abby Ciclette",
        'date_trajet'    => new \Datetime(),
        'heure_trajet'   => new \Datetime(),
        'ville'       => "Giou-de-Mammou",
        'aller_ou_retour' => true,
        'type_vehicule' => "Vélo",
        'commentaire'    => "Je part à l'heure !"
      ));

      return $this->render('GSBCovoitBundle:Covoit:index.html.twig',
                              array('listAnnonces' => $listAnnonces));
    }
}
