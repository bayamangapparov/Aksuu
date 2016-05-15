<?php

namespace Info\GalleryBundle\Entity;

use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Model\GalleryInterface;

/**
 * News
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PhotoGalleryRepository")
 */
class PhotoGalleryHasGallery
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     *
     * @ORM\ManyToOne(targetEntity="Info\GalleryBundle\Entity\PhotoGallery", inversedBy="photoGalleryHasGalleries")
     * @ORM\JoinColumn(name="photo_gallery_id", referencedColumnName="id")
     */
    private $photoGallery;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media",cascade={"persist"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="media", referencedColumnName="id")
     * })
     */
    private $media;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param Media $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * @return mixed
     */
    public function getPhotoGallery()
    {
        return $this->photoGallery;
    }

    /**
     * @param mixed $photoGallery
     */
    public function setPhotoGallery($photoGallery)
    {
        $this->photoGallery = $photoGallery;
    }

}
