<?php

namespace GSB\CovoitBundle\Controller;

use GSB\CovoitBundle\Entity\Demande;
use GSB\CovoitBundle\Entity\Salarie;
use GSB\CovoitBundle\Entity\Trajet;
use GSB\CovoitBundle\Entity\TypeVehicule;
use GSB\CovoitBundle\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CovoitController extends Controller
{
    public function indexAction()
    {
      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();

      $listTrajets  = $em->getRepository('GSBCovoitBundle:Trajet')->findAll();
      $listDemandes = $em->getRepository('GSBCovoitBundle:Demande')->findAll();

      return $this->render('GSBCovoitBundle:Covoit:index.html.twig',
                              array('listTrajets' => $listTrajets,
                                    'listDemandes'=> $listDemandes));
    }

    public function menuAction($limite)
    {
      if ($limite == NULL)
        $limite = 3;

      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();

      $listTrajets  = $em->getRepository('GSBCovoitBundle:Trajet')->findAll();

      return $this->render('GSBCovoitBundle:Covoit:menu.html.twig',
                          array('listTrajets' => $listTrajets,
                                'limite'      => $limite));
    }
}
