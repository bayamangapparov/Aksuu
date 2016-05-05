<?php

namespace Info\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('InfoPageBundle:Default:index.html.twig', array('name' => $name));
    }
}
