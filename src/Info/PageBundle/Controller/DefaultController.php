<?php

namespace Info\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('InfoPageBundle:Default:index.html.twig', array('name' => $name));
    }

    public function getHistoryPageAction()
    {
        $page = $this->getDoctrine()->getRepository('InfoPageBundle:Page')->find(1);
        return $this->render('InfoPageBundle:Default:showPage.html.twig', array('page' => $page));
    }

    public function getSostavPageAction()
    {
        $page = $this->getDoctrine()->getRepository('InfoPageBundle:Page')->find(2);
        return $this->render('InfoPageBundle:Default:showPage.html.twig', array('page' => $page));
    }

    public function getVacancyPageAction()
    {
        $page = $this->getDoctrine()->getRepository('InfoPageBundle:Page')->find(4);
        return $this->render('InfoPageBundle:Default:showPage.html.twig', array('page' => $page));
    }
    public function getContactPageAction()
    {
        $page = $this->getDoctrine()->getRepository('InfoPageBundle:Page')->find(5);
        return $this->render('InfoPageBundle:Default:showPage.html.twig', array('page' => $page));
    }
    
    


}
