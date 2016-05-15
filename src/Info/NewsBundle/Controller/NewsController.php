<?php

namespace Info\NewsBundle\Controller;

use Info\NewsBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    public function listMainNewsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('InfoNewsBundle:News');
        $entities = $repository->createQueryBuilder('news')
            ->orderBy('news.date', 'ASC')
            ->getQuery()
            ->getResult();
        $request = Request::createFromGlobals();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate($entities, $request->query->getInt('page', 1),1);


        return $this->render('InfoNewsBundle:News:listMainNews.html.twig', array('entities' => $pagination));
    }

    public function getNewsByIdAction(News $id)
    {
        return $this->render('InfoNewsBundle:News:getNews.html.twig',
            array('news' => $id));
    }


}
