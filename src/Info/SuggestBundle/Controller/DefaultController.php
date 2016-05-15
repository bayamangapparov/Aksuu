<?php

namespace Info\SuggestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('InfoSuggestBundle:Default:index.html.twig', array('name' => $name));
    }
}
