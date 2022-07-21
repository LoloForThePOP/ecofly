<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\TechnicRepository;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * @ORM\Entity(repositoryClass=TechnicRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Technic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textDescription;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    

    /**
     * the name of the logo (thumbnail) file representing the technic (example : img-4234564567.jpg)
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     *  @Assert\Image(
     *     maxSize = "2500k",
     *     maxSizeMessage = "Poids maximal Accepté pour l'image : 1500 k",
     *     mimeTypes={"image/png", "image/jpeg", "image/jpg", "image/webp"},
     *     mimeTypesMessage = "Pour ajouter un logo, le format de fichier ({{ type }}) n'est pas encore pris en compte. Les formats acceptés sont : {{ types }}"
     * )
     * @Vich\UploadableField(mapping="technic_logo_image", fileNameProperty="logo")
     * 
     * @var File|null
     */
    public $logoFile;














    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTextDescription(): ?string
    {
        return $this->textDescription;
    }

    public function setTextDescription(string $textDescription): self
    {
        $this->textDescription = $textDescription;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }



    
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }


    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $logoFile
     */
    public function setLogoFile(?File $logoFile = null): void
    {
        $this->logoFile = $logoFile;

        // It is required that at least one field changes if you are using doctrine
        // otherwise the event listeners won't be called and the file is lost
        // So we update one field

        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }






}
