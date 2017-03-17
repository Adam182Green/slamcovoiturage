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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CovoitController extends Controller
{
    public function indexAction(Request $request)
    {
      $session = $request->getSession();
      $currentUser = $session->get('currentUser');
      if($currentUser == null)
      {
        return $this->redirectToRoute('gsb_covoit_login');
      }
      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();
      $listTrajets  = $em->getRepository('GSBCovoitBundle:Trajet')->findAll();
      $listDemandes  = $em->getRepository('GSBCovoitBundle:Demande')->findAll();

      return $this->render('GSBCovoitBundle:Covoit:index.html.twig',
                              array('listTrajets' => $listTrajets,
                                    'listDemandes' => $listDemandes,
                                    'title' => 'Accueil',
                                    'subtitle' => 'Accueil',
                                    'currentUser' => $currentUser));
    }
    
    public function trajetAction(Request $request, $id)
    {
      $session = $request->getSession();
      $currentUser = $session->get('currentUser');
      if($currentUser == null)
      {
        return $this->redirectToRoute('gsb_covoit_login');
      }
      $em = $this->getDoctrine()->getManager();
      $listDemandes  = $em->getRepository('GSBCovoitBundle:Demande')->findAll();
      $trajet = $em->getRepository('GSBCovoitBundle:Trajet')->find($id);

      if (null === $trajet) {
        throw new NotFoundHttpException("Le trajet d'id ".$id." n'existe pas.");
      }
      return $this->render('GSBCovoitBundle:Covoit:trajet.html.twig',
                          array('trajet'  => $trajet,
                                'listDemandes' => $listDemandes,
                                'currentUser' => $currentUser));
    }
    public function salarieAction(Request $request, $id)
    {
      $session = $request->getSession();
      $currentUser = $session->get('currentUser');
      if($currentUser == null)
      {
        return $this->redirectToRoute('gsb_covoit_login');
      }
      $em = $this->getDoctrine()->getManager();
      $salarie = $em->getRepository('GSBCovoitBundle:Salarie')->find($id);
      if (null === $salarie) {
        throw new NotFoundHttpException("Le salarie d'id ".$id." n'existe pas.");
      }
      return $this->render('GSBCovoitBundle:Covoit:salarie.html.twig',
                          array('salarie'  => $salarie,
                                'currentUser' => $currentUser));
    }
    public function menuAction(Request $request, $limite)
    {
      $session = $request->getSession();
      $currentUser = $session->get('currentUser');
      if($currentUser == null)
      {
        return $this->redirectToRoute('gsb_covoit_login');
      }

      if ($limite == NULL)
        $limite = 3;
      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();
      $listTrajets  = $em->getRepository('GSBCovoitBundle:Trajet')->findBy(array(), array('id' => 'desc'));
      return $this->render('GSBCovoitBundle:Covoit:menu.html.twig',
                          array('listTrajets' => $listTrajets,
                                'limite'      => $limite,
                                'currentUser' => $currentUser));
    }
    public function mes_trajetsAction(Request $request)
    {
      $session = $request->getSession();
      $currentUser = $session->get('currentUser');
      if($currentUser == null)
      {
        return $this->redirectToRoute('gsb_covoit_login');
      }
      $em = $this->getDoctrine()->getManager();
      $title = "Mes trajets";
      $subtitle = "Mes trajets";
      $trajets = $em->getRepository('GSBCovoitBundle:Trajet')->findBy(array('auteurId' => $currentUser->getId()));
      $mes_trajets = array();
      foreach ($trajets as $trajet)
      {
          $mes_trajets[] = $trajet;
      }
      if (NULL === $mes_trajets) {
        throw new NotFoundHttpException("Vous n'avez pas encore proposé de trajet.");
      }
      return $this->render('GSBCovoitBundle:Covoit:listeTrajets.html.twig',
                          array('listTrajets'  => $mes_trajets,
                                'title' => $title,
                                'subtitle' => $subtitle,
                                'currentUser' => $currentUser));
    }


    public function mesReservationsAction(Request $request)
    {
        $session = $request->getSession();
        $currentUser = $session->get('currentUser');
        if($currentUser == null)
        {
          return $this->redirectToRoute('gsb_covoit_login');
        }
        $em = $this->getDoctrine()->getManager();
        $demandes = $em->getRepository('GSBCovoitBundle:Demande')->findBy(array('salarieId' => $currentUser->getId()));
        $trajets = array();
        foreach($demandes as $demande)
        {
            $trajet = $em->getRepository('GSBCovoitBundle:Trajet')->findOneById($demande->getTrajetId());
            array_push($trajets, $trajet);
        }
        return $this->render('GSBCovoitBundle:Covoit:listeTrajets.html.twig',
                          array('listTrajets'  => $trajets, 'title' => 'Mes réservations', 'subtitle' => 'Mes réservations', 'currentUser' => $currentUser));
    }

    public function nouveauTrajetAction(Request $request)
    {
        $session = $request->getSession();
        $currentUser = $session->get('currentUser');
        if($currentUser == null)
        {
          return $this->redirectToRoute('gsb_covoit_login');
        }
        $em = $this->getDoctrine()->getManager();

        $newTrajet = new Trajet();

        $form = $this->createFormBuilder($newTrajet)
            ->add('dateTrajet', DateType::class, array(
                                        'format' => 'yyyy-dd-MM  HH:i',
                                        'label' => "Date du trajet",
                                        'placeholder' => array('year' => '--', 'month' => '--', 'day' => '--'), // Date entre le jour courant et le dernier jour du mois
                                        'days' => range(date('d'), date('t')),
                                        'months' => range(date('m'), 12),
                                        'years' => range(date('Y'), date('Y', strtotime('+1 years'))) // Soit année actuelle, soit la suivante
                                        ))
            ->add('dateTrajet', DateType::class, array(
                                        'widget' => 'single_text',
                                        'format' => 'dd-MM-yyyy',
                                        'html5' => false,
                                        'attr' => ['class' => 'js-datepicker'],
                                        ))
            ->add('heureTrajet', TimeType::class, array('placeholder' => array('hour' => '--', 'minute' => '--'),
                                                        'label' => "Heure du trajet"))
            ->add('idVille', EntityType::class , array(
                  'label' => 'Ville',
                  'class' => 'GSBCovoitBundle:Ville',
                  'choice_label' => 'libelle'))
            ->add('allerOuRetour', ChoiceType::class,
                    array('label' => "Aller ou Retour",
                          'choices' => array(
                                      'aller' => 'false',
                                      'retour' => 'true'),
                          'choices_as_values' => true,
                          'multiple'=>false,
                          'expanded'=>true))
            ->add('idTypeVehicule', EntityType::class, array(
                  'label' => "Type du véhicule",
                  'class' => 'GSBCovoitBundle:TypeVehicule',
                  'choice_label' => 'libelle'))
            ->add('commentaire', TextType::class)
            ->add('creation', SubmitType::class, array('label' => "Poster un trajet"))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newTrajet = $form->getData();
            $user = $em->getRepository('GSBCovoitBundle:Salarie')->findOneById($currentUser->getId());
            $newTrajet->setAuteurId($user);

            $em->persist($newTrajet);
            $em->flush();
            $this->addFlash('success', 'Félicitations, le trajet a bien été publié.');
            return $this->redirectToRoute('gsb_covoit_homepage');
        }
        return $this->render('GSBCovoitBundle:Covoit:form.html.twig', array(
            'title' => 'Nouveau trajet',
            'subtitle' => 'Nouveau trajet',
            'currentUser' => $currentUser,
            'form' => $form->createView(),
        ));
    }

    public function historiqueAction(Request $request)
    {
        $session = $request->getSession();
        $currentUser = $session->get('currentUser');
        if($currentUser == null)
        {
          return $this->redirectToRoute('gsb_covoit_login');
        }

        $em = $this->getDoctrine()->getManager();
        $listeDemandes = $em->getRepository('GSBCovoitBundle:Demande')->findAll();
        $listeTrajets = $em->getRepository('GSBCovoitBundle:Trajet')->findAll();
        $trajets = array();
        //Liste des trajets en tan que passager
        foreach($listeDemandes as $demande)
        {
          if($demande->getSalarieId()->getId() == $currentUser->getId())
          {
            $trajet = $em->getRepository('GSBCovoitBundle:Trajet')->find($demande->getTrajetId());
            array_push($trajets, $trajet);
          }
        }
        //Liste des trajets en tan que conducteur

        foreach($listeTrajets as $trajet)
        {
          if($trajet->getAuteurId()->getId() == $currentUser->getId())
          {
            if( !in_array($trajet, $trajets))
            {
              $trajet = $em->getRepository('GSBCovoitBundle:Trajet')->find($trajet);
              array_push($trajets, $trajet);
            }
          }
        }

        return $this->render('GSBCovoitBundle:Covoit:listeTrajets.html.twig',
                          array('listTrajets'  => $trajets,
                                'title' => 'Historique',
                                'subtitle' => 'Historique',
                                'currentUser' => $currentUser
                              ));
    }

    public function profilAction(Request $request)
    {
      $session = $request->getSession();
      $currentUser = $session->get('currentUser');
      if($currentUser == null)
      {
        return $this->redirectToRoute('gsb_covoit_login');
      }
      $em = $this->getDoctrine()->getManager();

      $form = $this->createFormBuilder($currentUser)
          ->add('nom', TextType::class)
          ->add('prenom', TextType::class)
          ->add('email', EmailType::class) // label
          ->add('motDePasse', TextType::class)
          ->add('telephone', TextType::class)
          ->add('enregistrer', SubmitType::class, array('label' => "Enregistrer modifications"))
          ->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid())
       {
          $modifiedUser = $form->getData();
          $user = $em->getRepository('GSBCovoitBundle:Salarie')->findOneById($currentUser->getId());

          $user->setNom($modifiedUser->getNom());
          $user->setPrenom($modifiedUser->getPrenom());
          $user->setEmail($modifiedUser->getEmail());
          $user->setMotDePasse($modifiedUser->getMotDePasse());
          $user->setTelephone($modifiedUser->getTelephone());

          $session->set('currentUser', $user);

          $em->flush();
          $this->addFlash('success', 'Félicitations, votre profil a été mis à jour.');
          return $this->redirectToRoute('gsb_covoit_profil');
        }

        return $this->render('GSBCovoitBundle:Covoit:form.html.twig',
                          array('title' => 'Profil',
                                'subtitle' => 'Profil',
                                'currentUser' => $currentUser,
                                'form' => $form->createView(),
                              ));
    }

    public function reserverAction(Request $request, $id)
    {
        $session = $request->getSession();
        $currentUser = $session->get('currentUser');
        if($currentUser == null)
        {
          return $this->redirectToRoute('gsb_covoit_login');
        }

        $em = $this->getDoctrine()->getManager();
        $demande = new Demande();
        $listTrajets = $em->getRepository('GSBCovoitBundle:Trajet')->findAll();
        $listDemandes = $em->getRepository('GSBCovoitBundle:Demande')->findAll();        
        $trajet = $em->getRepository('GSBCovoitBundle:Trajet')->findOneBy(array('id' => $id));
        $user = $em->getRepository('GSBCovoitBundle:Salarie')->findOneBy(array('id' => $currentUser->getId()));
        $date = new \DateTime('today');

        $demande->setTrajetId($trajet);
        $demande->setSalarieId($user);
        $demande->setDateDemande($date);
        $demande->setValidee(false);

        foreach($listDemandes as $uneDemande)
        {
          if( ( $demande->getSalarieId() && $demande->getTrajetId() ) == ( $uneDemande->getSalarieId() && $uneDemande->getTrajetId() ) ) 
          {
            $this->addFlash('error', 'Vous avez déjà réservé ce trajet.');

            return $this->render('GSBCovoitBundle:Covoit:index.html.twig',
                              array('listTrajets'  => $listTrajets,
                                    'listDemandes' => $listDemandes,
                                    'title' => 'Accueil',
                                    'subtitle' => 'Accueil',
                                    'currentUser' => $currentUser));
              }
        }
        $em->persist($demande);
        $em->flush();
        $this->addFlash('success', 'Félicitations, vous avez réservé le trajet avec succès.');

        return $this->render('GSBCovoitBundle:Covoit:index.html.twig',
                          array('listTrajets'  => $listTrajets,
                                'listDemandes' => $listDemandes,
                                'title' => 'Accueil',
                                'subtitle' => 'Accueil',
                                'currentUser' => $currentUser));
    }
}
