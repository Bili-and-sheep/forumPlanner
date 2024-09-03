<?php

namespace App\Entity;

use App\Repository\TimeslotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeslotRepository::class)]
class Timeslot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDateTime = null;

    /**
     * @var Collection<int, Group>
     */
    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'participatingTo')]
    private Collection $participate;

    /**
     * @var Collection<int, Stand>
     */
    #[ORM\OneToMany(targetEntity: Stand::class, mappedBy: 'timeSlots')]
    private Collection $contains;

    public function __construct()
    {
        $this->participate = new ArrayCollection();
        $this->contains = new ArrayCollection();
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

    public function getStartDateTime(): ?\DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(\DateTimeInterface $startDateTime): static
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getParticipate(): Collection
    {
        return $this->participate;
    }

    public function addParticipate(Group $participate): static
    {
        if (!$this->participate->contains($participate)) {
            $this->participate->add($participate);
        }

        return $this;
    }

    public function removeParticipate(Group $participate): static
    {
        $this->participate->removeElement($participate);

        return $this;
    }

    /**
     * @return Collection<int, Stand>
     */
    public function getContains(): Collection
    {
        return $this->contains;
    }

    public function addContain(Stand $contain): static
    {
        if (!$this->contains->contains($contain)) {
            $this->contains->add($contain);
            $contain->setTimeSlots($this);
        }

        return $this;
    }

    public function removeContain(Stand $contain): static
    {
        if ($this->contains->removeElement($contain)) {
            // set the owning side to null (unless already changed)
            if ($contain->getTimeSlots() === $this) {
                $contain->setTimeSlots(null);
            }
        }

        return $this;
    }
}
