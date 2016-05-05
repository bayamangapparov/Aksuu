<?php

namespace Info\GalleryBundle\Entity;

use CMS\CoreBundle\DBAL\BaseTranslatable;
use Prezent\Doctrine\Translatable\Annotation as Prezent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Info\GalleryBundle\Entity\Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="Info\GalleryBundle\Entity\VideoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Video extends BaseTranslatable
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\File(
     *     maxSize = "500M",
     *     mimeTypes = {"video/mpeg", "video/mp4", "video/quicktime", "video/x-ms-wmv", "video/x-msvideo", "video/x-flv"},
     *     mimeTypesMessage = "ce format de video est inconnu",
     *     uploadIniSizeErrorMessage = "uploaded file is larger than the upload_max_filesize PHP.ini setting",
     *     uploadFormSizeErrorMessage = "uploaded file is larger than allowed by the HTML file input field",
     *     uploadErrorMessage = "uploaded file could not be uploaded for some unknown reason",
     *     maxSizeMessage = "fichier trop volumineux"
     * )
     */
    public $file;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;
//* @Assert\NotBlank

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;


    /**
     * @var string $thumbnailPath
     *
     * @ORM\Column(name="thumbnail_path", type="string", length=255, nullable=true)
     */
    private $thumbnailPath;

//    /**
//     * @var text $legende
//     *
//     * @ORM\Column(name="legende", type="text")
//     */
//    private $legende;

    /**
     * @var date $createdAt
     *
     * @ORM\Column(name="created_at", type="date")
     */
    private $createdAt;

    //     * @Assert\Max(limit = 50, message = "Entrez un nombre inférieur à 50.")
//     * @Assert\Min(limit = 1, message = "Entrez un nombre supérieur à 0.")

//    /**
//     * @var smallint $position
//     *
//     * @ORM\Column(name="position", type="smallint")
//     */
//    private $position;

//    /**
//     * @var string $isPublic
//     *
//     * @ORM\Column(name="is_public", type="string", length=25)
//     */
//    private $isPublic;

    /**
     * @Prezent\Translations(targetEntity="\Info\GalleryBundle\Entity\VideoTranslation")
     */
    protected $translations;


    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->createdAt = new \DateTime();
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

    public function getText()
    {
        return $this->translate()->getText();
    }

    public function setText($text)
    {
        $this->translate()->setText($text);
        return $this;
    }



    //les 4 fonctions suivantes sont pour le upload
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/videos';
    }

    // **** les 3 fonctions suivantes servent à gérer le callback et l'upload de file
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {

        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->path = uniqid().'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // ** on peut mettre ça si on veut faire que le nom corresponde au nom de l'image original
        //$this->setName($this->file->getClientOriginalName());

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

//    /**
//     * Set legende
//     *
//     * @param text $legende
//     */
//    public function setLegende($legende)
//    {
//        $this->legende = $legende;
//    }
//
//    /**
//     * Get legende
//     *
//     * @return text
//     */
//    public function getLegende()
//    {
//        return $this->legende;
//    }

    /**
     * Set dateCreated
     *
     * @param date $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * Get dateCreated
     *
     * @return date
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return date
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getThumbnailPath()
    {
        return $this->thumbnailPath;
    }

    /**
     * @param string $thumbnailPath
     */
    public function setThumbnailPath($thumbnailPath)
    {
        $this->thumbnailPath = $thumbnailPath;
    }

//    /**
//     * Set position
//     *
//     * @param smallint $position
//     */
//    public function setPosition($position)
//    {
//        $this->position = $position;
//    }
//
//    /**
//     * Get position
//     *
//     * @return smallint
//     */
//    public function getPosition()
//    {
//        return $this->position;
//    }

//    /**
//     * Set isPublic
//     *
//     * @param boolean $isPublic
//     */
//    public function setIsPublic($isPublic)
//    {
//        $this->isPublic = $isPublic;
//    }
//
//    /**
//     * Get isPublic
//     *
//     * @return boolean
//     */
//    public function getIsPublic()
//    {
//        return $this->isPublic;
//    }
}