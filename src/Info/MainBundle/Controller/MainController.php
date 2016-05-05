<?php

namespace Info\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MainController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('InfoMainBundle:Test')->findAll();
//        return $this->render('InfoMainBundle:Test:index.html.twig', array('entities'=>$entities) );
        return $this->render('InfoMainBundle:Main:index.html.twig', array('entities'=>$entities));
    }
}
