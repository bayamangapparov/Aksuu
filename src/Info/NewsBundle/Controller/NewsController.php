<?php

namespace Info\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function listMainNewsAction()
    {
        $news = $this->getDoctrine()->getRepository('InfoNewsBundle:News')->findAll();
        return $this->render('InfoNewsBundle:News:listMainNews.html.twig', array('entities' => $news));
    }
}
