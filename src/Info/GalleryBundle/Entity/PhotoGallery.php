<?php

namespace Info\GalleryBundle\Entity;

use CMS\CoreBundle\DBAL\BaseTranslatable;
use Prezent\Doctrine\Translatable\Annotation as Prezent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PhotoGallery
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Info\GalleryBundle\Entity\PhotoGalleryRepository")
 */
class PhotoGallery extends BaseTranslatable
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
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media",cascade={"persist"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="cover_id", referencedColumnName="id")
     * })
     */
    private $cover;

    /**
     *
     * @ORM\OneToMany(targetEntity="Info\GalleryBundle\Entity\PhotoGalleryHasGallery", mappedBy="photoGallery", cascade={"all"})
     *
     */
    private $photoGalleryHasGalleries;

    /**
     * @Prezent\Translations(targetEntity="\Info\GalleryBundle\Entity\PhotoGalleryTranslation")
     */
    protected $translations;


    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->photoGalleryHasGalleries = new ArrayCollection();
        $this->createDate = new \DateTime();
    }

    public function __toString()
    {
        if($this->currentLocale == null){
            $this->currentLocale = 'ru';
        }
        return $this->getTitle();
    }

    public function getTitle()
    {
        return $this->translate()->getTitle();
    }

    public function setTitle($title)
    {
        $this->translate()->setTitle($title);
        return $this;
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
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return PhotoGallery
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

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return mixed
     */
    public function getPhotoGalleryHasGalleries()
    {
        return $this->photoGalleryHasGalleries;
    }

    /**
     * @param mixed $photoGalleryHasGalleries
     */
    public function setPhotoGalleryHasGalleries($photoGalleryHasGalleries)
    {
        $this->photoGalleryHasGalleries = $photoGalleryHasGalleries;
    }

    /**
     * @param mixed $photoGalleryHasGalleries
     */
    public function addPhotoGalleryHasGalleries($photoGalleryHasGalleries)
    {
        $this->photoGalleryHasGalleries[] = $photoGalleryHasGalleries;
    }
}
