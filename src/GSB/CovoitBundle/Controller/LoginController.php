<?php
namespace GSB\CovoitBundle\Controller;

use GSB\CovoitBundle\Entity\Login;
use GSB\CovoitBundle\Entity\Salarie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginController extends Controller
{
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        if($session->get('currentUser') != null)
        {
          return $this->redirectToRoute('gsb_covoit_homepage');
        }
        $em = $this->getDoctrine()->getManager();
        $login = new Login();
        $salaries = $em->getRepository('GSBCovoitBundle:Salarie')->findAll();

        $form = $this->createFormBuilder($login)
            ->add('email', EmailType::class, array('label' => "Email"))
            ->add('motDePasse', PasswordType::class, array('label' => "Mot de passe"))
            ->add('connexion', SubmitType::class, array('label' => "Connexion"))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $login = $form->getData();
            foreach($salaries as $salarie)
            {
                if($salarie->getEmail() == $login->getEmail() && $salarie->getMotDePasse() == $login->getMotDePasse())
                {
                  $msg = 'Identification réussie ! Bienvenue '.$salarie->getPrenom().' '.$salarie->getNom();
                  return $this->setcurrentUser($session, $salarie, $msg);
                }
            }
        }
        return $this->render('GSBCovoitBundle:Covoit:form.html.twig', array(
            'title' => "Connexion",
            'subtitle' => "Connexion",
            'form' => $form->createView(),
        ));
    }

    public function inscriptionAction(Request $request)
    {
        $session = $request->getSession();
        if($session->get('currentUser') != null)
        {
          return $this->redirectToRoute('gsb_covoit_homepage');
        }
        $em = $this->getDoctrine()->getManager();
        $newSalarie = new Salarie();
        $salaries = $em->getRepository('GSBCovoitBundle:Salarie')->findAll();
        $form = $this->createFormBuilder($newSalarie)
            ->add('nom', TextType::class, array('label' => "Nom"))
            ->add('prenom', TextType::class, array('label' => "Prénom"))
            ->add('telephone', TextType::class, array('label' => "Téléphone"))
            ->add('email', EmailType::class, array('label' => "Email"))
            ->add('motDePasse', PasswordType::class, array('label' => "Mot de passe"))
            ->add('inscription', SubmitType::class, array('label' => "Inscription"))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newSalarie = $form->getData();
            $unique = true;
            $nbSalaries = count($salaries);
            $index = 0;
            while($index < $nbSalaries && $unique)
            {
                if($salaries[$index]->getEmail() == $newSalarie->getEmail())
                {
                    $unique = false;
                }
                if($unique)
                {
                    $em->persist($newSalarie);
                    $em->flush();
                    return $this->setcurrentUser($session, $newSalarie, 'Félicitations, votre inscription est réussie !');
                    // 4 -[Si on a le temps] Envoyer un mail de confirmation d'inscription
                }
            }
        }
        return $this->render('GSBCovoitBundle:Covoit:form.html.twig', array(
            'title' => 'Inscription',
            'subtitle' => 'Inscription',
            'form' => $form->createView(),
        ));
    }

    public function logoutAction(Request $request)
    {
      $session = $request->getSession();
      $session->set('currentUser', null);
      return $this->redirectToRoute('gsb_covoit_login');
    }

    private function setcurrentUser($session, $salarie, $msg)
    {
      $session->set('currentUser', $salarie);
      $this->addFlash('success', $msg);
      return $this->redirectToRoute('gsb_covoit_homepage');
    }
}
