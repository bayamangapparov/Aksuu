<?php

namespace Info\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TestController extends Controller
{
    public function indexAction()
    {
        return $this->render('InfoMainBundle:Main:index.html.twig');
    }

    public function testAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('InfoMainBundle:Test')->findAll();
        return $this->render('InfoMainBundle:Test:index.html.twig', array('entities'=>$entities) );
    }
}
