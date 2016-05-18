<?php

namespace Info\PageBundle\Controller;

use Info\PageBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function topMenuAction()
    {
        $top = $this->getDoctrine()->getRepository('InfoPageBundle:PagePosition')->findOneByTitle('top');
        $topMenu = $this->getDoctrine()->getRepository('InfoPageBundle:Page')->findByPagePosition($top);
        return $this->render('InfoPageBundle:Page:topMenu.html.twig', array('entity' => $topMenu));
    }
    public function leftMenuAction()
    {
        $left = $this->getDoctrine()->getRepository('InfoPageBundle:PagePosition')->findOneByTitle('left');
        $leftMenu = $this->getDoctrine()->getRepository('InfoPageBundle:Page')->findByPagePosition($left);
        return $this->render('InfoPageBundle:Page:leftMenu.html.twig', array('entity' => $leftMenu));
    }

    public function getPageAction(Page $id)
    {
        $page = $id;

        return $this->render('InfoPageBundle:Page:getPage.html.twig',
            array('page'=>$page)
            );
    }
}
