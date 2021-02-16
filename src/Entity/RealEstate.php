<?php

namespace App\Entity;

use App\Repository\RealEstateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RealEstateRepository::class)
 */
class RealEstate
{

public const SIZES = [
        1 => 'Studio',
        2 => 'T2',
        3 => 'T3',
        4 => 'T4',
        5 => 'T5',
];

    /** Clé primaire
     * @ORM\Id
     * autu incrément
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=15)
     * @Assert\Regex(
     *     pattern="/(mince|puree)/",
     *     match=false,
     *     message="Tu ne peux pas dire le mot m***** ou p****"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min=10, max=400)
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $rooms;



    /**
     * @ORM\Column(type="boolean")
     */
    private $sold;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="realEstates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="realEstates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;

    }


    public function getDisplayableRooms(): string {
        $sizes = [
            1 => 'Studio',
            2 => 'T2',
            3 => 'T3',
            4 => 'T4',
            5 => 'T5',
        ];
        return $sizes[$this->rooms];
    }



    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }


    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
