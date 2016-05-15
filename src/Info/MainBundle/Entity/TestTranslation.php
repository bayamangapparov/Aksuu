<?php

namespace Info\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Prezent\Doctrine\Translatable\Annotation as Prezent;
use Prezent\Doctrine\Translatable\Entity\AbstractTranslation;
use Prezent\Doctrine\Translatable\TranslatableInterface;
use CMS\CoreBundle\DBAL\BaseTranslatable;


/**
 * @ORM\Entity
 */
class TestTranslation extends AbstractTranslation
{
    /**
     * @Prezent\Translatable(targetEntity="\Info\MainBundle\Entity\Test")
     */
    protected $translatable;

    /**
     * @ORM\Column(type="string")
     */
    private $title = "";

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