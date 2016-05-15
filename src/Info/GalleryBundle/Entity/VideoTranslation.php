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
class VideoTranslation extends AbstractTranslation
{
    /**
     * @Prezent\Translatable(targetEntity="\Info\GalleryBundle\Entity\Video")
     */
    protected $translatable;

    /**
     * @ORM\Column(type="string")
     */
    private $title = "";

    /**
     * @ORM\Column(type="text")
     */
    private $text = "";

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }



    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

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