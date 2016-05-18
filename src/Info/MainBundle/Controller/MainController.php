<?php

namespace Info\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('InfoMainBundle:Test')->findAll();
//        return $this->render('InfoMainBundle:Test:index.html.twig', array('entities'=>$entities) );
        return $this->render('InfoMainBundle:Main:index.html.twig', array('entities'=>$entities));
    }

    public function searchAction()
    {
        $search = $_POST['search'];
        $news = $this->getDoctrine()->getEntityManager()
            ->getRepository('InfoNewsBundle:News')
            ->createQueryBuilder('news')
            ->where('news.title LIKE :search')
            ->orWhere('news.text LIKE :search')
            ->setParameter('search', '%'.$search.'%'.'%')
            ->getQuery()
            ->getResult()
        ;
        $request = Request::createFromGlobals();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate($news, $request->query->getInt('page', 1),5);



        return $this->render('InfoMainBundle:Main:resultSearch.html.twig', array('entities'=>$pagination));

    }
}
