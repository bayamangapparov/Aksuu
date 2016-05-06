<?php

namespace Info\NewsBundle\Controller;

use Info\NewsBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function listMainNewsAction()
    {
        $news = $this->getDoctrine()->getRepository('InfoNewsBundle:News')->findAll();
        return $this->render('InfoNewsBundle:News:listMainNews.html.twig', array('entities' => $news));
    }

    public function getNewsAction(News $id)
    {
        return $this->render('InfoNewsBundle:News:getNews.html.twig',
            array('news' => $id));
    }


}
