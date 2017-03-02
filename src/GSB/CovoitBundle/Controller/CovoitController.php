<?php

namespace GSB\CovoitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CovoitController extends Controller
{
    public function indexAction()
    {
        return $this->render('GSBCovoitBundle:Covoit:index.html.twig');
    }
}
