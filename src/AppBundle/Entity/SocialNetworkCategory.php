<?php
namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TitleTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SocialNetworkCategory
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SocialNetworkCategoryRepository")
 * @Vich\Uploadable
 */
class SocialNetworkCategory extends AbstractBase
{
    use TitleTrait;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="uploads", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize = "10M",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png", "image/gif"}
     * )
     * @Assert\Image(minWidth = 1200)
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SocialNetwork", mappedBy="category")
     */
    private $socialNetworks;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * SocialNetworkCategory constructor.
     */
    public function __construct()
    {
        $this->socialNetworks = new ArrayCollection();
    }

    /**
     * @return File|UploadedFile
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set imageFile
     *
     * @param File|UploadedFile $imageFile
     *
     * @return SocialNetworkCategory
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     * @return SocialNetworkCategory
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSocialNetworks()
    {
        return $this->socialNetworks;
    }

    /**
     * @param ArrayCollection $socialNetworks
     * @return SocialNetworkCategory
     */
    public function setSocialNetworks($socialNetworks)
    {
        $this->socialNetworks = $socialNetworks;
        return $this;
    }


    public function __toString() {

        return $this->getTitle() ? $this->getTitle() : '---';
    }

}