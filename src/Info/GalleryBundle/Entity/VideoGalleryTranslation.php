<?php

namespace Info\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Prezent\Doctrine\Translatable\Annotation as Prezent;
use Prezent\Doctrine\Translatable\Entity\AbstractTranslation;
use Prezent\Doctrine\Translatable\TranslatableInterface;
use CMS\CoreBundle\DBAL\BaseTranslatable;


/**
 * @ORM\Entity
 */
class VideoGalleryTranslation extends AbstractTranslation
{
    /**
     * @Prezent\Translatable(targetEntity="\Info\GalleryBundle\Entity\VideoGallery")
     */
    protected $translatable;

    /**
     * @ORM\Column(type="string")
     */
    private $url = "";

//    /**
//     * @ORM\Column(type="text")
//     */
//    private $text = "";

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }



//    /**
//     * @return mixed
//     */
//    public function getText()
//    {
//        return $this->text;
//    }
//
//    /**
//     * @param mixed $text
//     */
//    public function setText($text)
//    {
//        $this->text = $text;
//    }

    /**
     * @return mixed
     */
    public function getTranslatable()
    {
        return $this->translatable;
    }

    /**
     * @param mixed $translatable
     */
    public function setTranslatable(TranslatableInterface $translatable = null)
    {
        $this->translatable = $translatable;
    }


    // Getters and setters
}