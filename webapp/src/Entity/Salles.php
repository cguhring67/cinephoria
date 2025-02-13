<?php

namespace App\Entity;

use App\Repository\SallesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SallesRepository::class)]
class Salles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $places;

    #[ORM\Column]
    private array $technologies = [];

    #[ORM\Column(length: 45)]
    private string $salle_nom;

    #[ORM\ManyToOne(inversedBy: 'salles')]
    #[ORM\JoinColumn(nullable: false)]
    private Cinemas $cinema_id;

    /**
     * @var Collection<int, Seances>
     */
    #[ORM\OneToMany(targetEntity: Seances::class, mappedBy: 'salle_id', orphanRemoval: true)]
    private Collection $seances;

    public function __construct()
    {
        $this->seances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaces(): int
    {
        return $this->places;
    }

    public function setPlaces(int $places): static
    {
        $this->places = $places;

        return $this;
    }

    public function getTechnologies(): array
    {
        return $this->technologies;
    }

    public function setTechnologies(array $technologies): static
    {
        $this->technologies = $technologies;

        return $this;
    }

    public function getSalleNom(): string
    {
        return $this->salle_nom;
    }

    public function setSalleNom(string $salle_nom): static
    {
        $this->salle_nom = $salle_nom;

        return $this;
    }

    public function getCinemaId(): Cinemas
    {
        return $this->cinema_id;
    }

    public function setCinemaId(Cinemas $cinema_id): static
    {
        $this->cinema_id = $cinema_id;

        return $this;
    }

    /**
     * @return Collection<int, Seances>
     */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seances $seance): static
    {
        if (!$this->seances->contains($seance)) {
            $this->seances->add($seance);
            $seance->setSalleId($this);
        }

        return $this;
    }

    public function removeSeance(Seances $seance): static
    {
        if ($this->seances->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getSalleId() === $this) {
                $seance->setSalleId(null);
            }
        }

        return $this;
    }
}
