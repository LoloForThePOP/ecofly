<?php

namespace App\Entity;


use Serializable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TechnicRepository;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * @ORM\Entity(repositoryClass=TechnicRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Technic implements Serializable
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
     *     maxSizeMessage = "Poids maximal Accepté pour l'image : {{ limit }} {{ suffix }}",
     *     mimeTypes={"image/png", "image/jpeg", "image/jpg", "image/webp", "image/svg+xml"},
     *     mimeTypesMessage = "Pour ajouter un logo, le format de fichier ({{ type }}) n'est pas encore pris en compte. Les formats acceptés sont : {{ types }}"
     * )
     * @Vich\UploadableField(mapping="technic_logo_image", fileNameProperty="logo")
     * 
     * @var File|null
     */
    public $logoFile;

  

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $pros;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cons;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAdminValidated;

    /**
     * @ORM\OneToMany(targetEntity=Slide::class, mappedBy="technicPresentation")
     */
    private $slides;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="technics")
     */
    private $creator;






    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->isAdminValidated = false;
        $this->slides = new ArrayCollection();

    }


    

    public function serialize()
    {
        return serialize($this->id);
    }
    
    public function unserialize($serialized)
    {
        $this->id = unserialize($serialized);
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

  


    public function getPros(): ?string
    {
        return $this->pros;
    }

    public function setPros(?string $pros): self
    {
        $this->pros = $pros;

        return $this;
    }

    public function getCons(): ?string
    {
        return $this->cons;
    }

    public function setCons(?string $cons): self
    {
        $this->cons = $cons;

        return $this;
    }

    public function getIsAdminValidated(): ?bool
    {
        return $this->isAdminValidated;
    }

    public function setIsAdminValidated(?bool $isAdminValidated): self
    {
        $this->isAdminValidated = $isAdminValidated;

        return $this;
    }

    /**
     * @return Collection<int, Slide>
     */
    public function getSlides(): Collection
    {
        return $this->slides;
    }

    public function addSlide(Slide $slide): self
    {
        if (!$this->slides->contains($slide)) {
            $this->slides[] = $slide;
            $slide->setTechnicPresentation($this);
        }

        return $this;
    }

    public function removeSlide(Slide $slide): self
    {
        if ($this->slides->removeElement($slide)) {
            // set the owning side to null (unless already changed)
            if ($slide->getTechnicPresentation() === $this) {
                $slide->setTechnicPresentation(null);
            }
        }

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }






}
