<?php

namespace Info\GalleryBundle\Controller;

use Info\GalleryBundle\Entity\Video;
use Info\GalleryBundle\Entity\VideoGallery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VideoGalleryController extends Controller
{




    public function videoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository('InfoGalleryBundle:Video')->findAll();
//        var_dump($videos[0]);
//        dump($videos[0]->getWebPath());
//        die();
        return $this->render('InfoGalleryBundle:Videos:video_test.html.twig', array('videos' => $videos ));
    }

    public function videosAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('InfoGalleryBundle:VideoGallery');
        $videos = $em->createQueryBuilder('videos')
            ->orderBy('videos.createDate', 'DESC')

            ->getQuery()
            ->getResult();
        return $this->render('InfoGalleryBundle:Videos:video_gallery.html.twig', array('videos' => $videos ));
    }

}
