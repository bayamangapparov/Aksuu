<?php

namespace Info\GalleryBundle\Entity;

use CMS\CoreBundle\DBAL\BaseTranslatable;
use Prezent\Doctrine\Translatable\Annotation as Prezent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * VideoGallery
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Info\GalleryBundle\Entity\VideoGalleryRepository")
 */
class VideoGallery extends BaseTranslatable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;


    /**
     * @Prezent\Translations(targetEntity="\Info\GalleryBundle\Entity\VideoGalleryTranslation")
     */
    protected $translations;



    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->createDate = new \DateTime();
    }

    public function getUrl()
    {
        return $this->translate()->getUrl();
    }

    public function setUrl($url)
    {
        $this->translate()->setUrl($url);
        return $url;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return VideoGallery
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return VideoGallery
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }
}
