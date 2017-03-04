<?php
namespace GSB\CovoitBundle\Controller;
use GSB\CovoitBundle\Entity\Demande;
use GSB\CovoitBundle\Entity\Salarie;
use GSB\CovoitBundle\Entity\Trajet;
use GSB\CovoitBundle\Entity\TypeVehicule;
use GSB\CovoitBundle\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CovoitController extends Controller
{
    public function indexAction(Request $request)
    {
      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();
      $session = $request->getSession();
      $curentUser = $session->get('currentUser');
      $listTrajets  = $em->getRepository('GSBCovoitBundle:Trajet')->findAll();
      
      return $this->render('GSBCovoitBundle:Covoit:index.html.twig',
                              array('listTrajets' => $listTrajets,
                                    'title' => 'Accueil',
                                    'subtitle' => 'Accueil',
                                    'currentUser' => $curentUser));
    }
    public function trajetAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $session = $request->getSession();
      $curentUser = $session->get('currentUser');
      $trajet = $em->getRepository('GSBCovoitBundle:Trajet')->find($id);
      if (null === $trajet) {
        throw new NotFoundHttpException("Le trajet d'id ".$id." n'existe pas.");
      }
      return $this->render('GSBCovoitBundle:Covoit:trajet.html.twig',
                          array('trajet'  => $trajet,
                                'currentUser' => $curentUser));
    }
    public function salarieAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $session = $request->getSession();
      $curentUser = $session->get('currentUser');
      $salarie = $em->getRepository('GSBCovoitBundle:Salarie')->find($id);
      if (null === $salarie) {
        throw new NotFoundHttpException("Le salarie d'id ".$id." n'existe pas.");
      }
      return $this->render('GSBCovoitBundle:Covoit:salarie.html.twig',
                          array('salarie'  => $salarie,
                                'currentUser' => $curentUser));
    }
    public function menuAction(Request $request, $limite)
    {
      if ($limite == NULL)
        $limite = 3;
      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();
      $session = $request->getSession();
      $curentUser = $session->get('currentUser');
      $listTrajets  = $em->getRepository('GSBCovoitBundle:Trajet')->findAll();
      return $this->render('GSBCovoitBundle:Covoit:menu.html.twig',
                          array('listTrajets' => $listTrajets,
                                'limite'      => $limite,
                                'currentUser' => $curentUser));
    }

    public function mes_trajetsAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $session = $request->getSession();
      $curentUser = $session->get('currentUser');
      $title = "Mes trajets";
      $subtitle = "Mes trajets";
      $trajets = $em->getRepository('GSBCovoitBundle:Trajet')->findBy(array('auteurId' => $curentUser->getId()));
      $mes_trajets = array();

      foreach ($trajets as $trajet)
      {
          $mes_trajets[] = $trajet;
      }
      if (NULL === $mes_trajets) {
        throw new NotFoundHttpException("Vous n'avez pas encore proposé de trajet.");
      }
      return $this->render('GSBCovoitBundle:Covoit:index.html.twig',
                          array('listTrajets'  => $mes_trajets,
                                'title' => $title,
                                'subtitle' => $subtitle,
                                'currentUser' => $curentUser));
    }

    public function mesReservationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $curentUser = $session->get('currentUser');
        $demandes = $em->getRepository('GSBCovoitBundle:Demande')->findBy(array('salarieId' => $curentUser->getId()));
        $trajets = array();

        foreach($demandes as $demande)
        {
            $trajet = $em->getRepository('GSBCovoitBundle:Trajet')->findOneById($demande->getTrajetId());
            array_push($trajets, $trajet);
        }
        return $this->render('GSBCovoitBundle:Covoit:index.html.twig',
                          array('listTrajets'  => $trajets, 'title' => 'Mes réservations', 'subtitle' => 'Mes réservations', 'currentUser' => $curentUser));
    }
}
