<?php

namespace Info\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('InfoNewsBundle:Default:index.html.twig', array('name' => $name));
    }
}
