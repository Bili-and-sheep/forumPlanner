<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'ownedGroups')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    /**
     * @var Collection<int, Timeslot>
     */
    #[ORM\ManyToMany(targetEntity: Timeslot::class, mappedBy: 'participate')]
    private Collection $participatingTo;

    public function __construct()
    {
        $this->participatingTo = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Timeslot>
     */
    public function getParticipatingTo(): Collection
    {
        return $this->participatingTo;
    }

    public function addParticipatingTo(Timeslot $participatingTo): static
    {
        if (!$this->participatingTo->contains($participatingTo)) {
            $this->participatingTo->add($participatingTo);
            $participatingTo->addParticipate($this);
        }

        return $this;
    }

    public function removeParticipatingTo(Timeslot $participatingTo): static
    {
        if ($this->participatingTo->removeElement($participatingTo)) {
            $participatingTo->removeParticipate($this);
        }

        return $this;
    }
}
