<?php

namespace App\Entity;

use App\Repository\ForumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForumRepository::class)]
class Forum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 8192)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'organizeForum')]
    private Collection $Organizer;

    /**
     * @var Collection<int, Stand>
     */
    #[ORM\OneToMany(targetEntity: Stand::class, mappedBy: 'OnWhichForum')]
    private Collection $whichStand;

    public function __construct()
    {
        $this->Organizer = new ArrayCollection();
        $this->whichStand = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getOrganizer(): Collection
    {
        return $this->Organizer;
    }

    public function addOrganizer(User $organizer): static
    {
        if (!$this->Organizer->contains($organizer)) {
            $this->Organizer->add($organizer);
        }

        return $this;
    }

    public function removeOrganizer(User $organizer): static
    {
        $this->Organizer->removeElement($organizer);

        return $this;
    }

    /**
     * @return Collection<int, Stand>
     */
    public function getWhichStand(): Collection
    {
        return $this->whichStand;
    }

    public function addWhichStand(Stand $whichStand): static
    {
        if (!$this->whichStand->contains($whichStand)) {
            $this->whichStand->add($whichStand);
            $whichStand->setOnWhichForum($this);
        }

        return $this;
    }

    public function removeWhichStand(Stand $whichStand): static
    {
        if ($this->whichStand->removeElement($whichStand)) {
            // set the owning side to null (unless already changed)
            if ($whichStand->getOnWhichForum() === $this) {
                $whichStand->setOnWhichForum(null);
            }
        }

        return $this;
    }
}
