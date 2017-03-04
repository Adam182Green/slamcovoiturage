<?php

namespace GSB\CovoitBundle\Controller;

use GSB\CovoitBundle\Entity\Login;
use GSB\CovoitBundle\Entity\Salarie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginController extends Controller
{

    public function loginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $login = new Login();
        $salaries = $em->getRepository('GSBCovoitBundle:Salarie')->findAll();
        
        $form = $this->createFormBuilder($login)
            ->add('email', EmailType::class)
            ->add('motDePasse', PasswordType::class)
            ->add('connexion', SubmitType::class, array('label' => "Connexion"))
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $login = $form->getData();
            foreach($salaries as $salarie)
            {
                if($salarie->getEmail() == $login->getEmail() && $salarie->getMotDePasse() == $login->getMotDePasse())
                {
                    // currentUser = $salarie
                    return $this->redirectToRoute('gsb_covoit_homepage');
                }
            }
        }
        
        return $this->render('GSBCovoitBundle:Covoit:login.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function inscriptionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $newSalarie = new Salarie();
        $salaries = $em->getRepository('GSBCovoitBundle:Salarie')->findAll();
        
        $form = $this->createFormBuilder($newSalarie)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('telephone', NumberType::class)
            ->add('email', EmailType::class)
            ->add('motDePasse', PasswordType::class)
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
                    
                    return $this->redirectToRoute('gsb_covoit_homepage');
                }
            }
        }
        
        return $this->render('GSBCovoitBundle:Covoit:login.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}