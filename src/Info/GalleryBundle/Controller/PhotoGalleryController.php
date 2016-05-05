<?php

namespace Info\GalleryBundle\Controller;

use Info\GalleryBundle\Entity\PhotoGallery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PhotoGalleryController extends Controller
{
    public function photosAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('InfoGalleryBundle:PhotoGallery');
        $photos = $em->createQueryBuilder('photos')
            ->orderBy('photos.createDate', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();

        $em = $this->getDoctrine()->getManager()->getRepository('InfoGalleryBundle:PhotoGallery');
        $photo = $em->createQueryBuilder('photos')
            ->orderBy('photos.createDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $this->render('InfoGalleryBundle:Photos:photo_gallery.html.twig', array('albums' => $photos, 'album'=>$photo));
    }



    public function getAlbumAction(PhotoGallery $photoGallery)
    {
        return $this->render('InfoGalleryBundle:Photos:photo_gallery_info.html.twig', array('entity' => $photoGallery));
    }

}
