<?php

namespace App\Entity;

use App\Repository\SeancesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeancesRepository::class)]
class Seances
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $date_debut;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $date_fin;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private Films $film_id;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private Salles $salle_id;

    #[ORM\Column]
    private ?int $cinema_id = null;
    private ?int $duree_film = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): \DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): \DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getFilmId(): Films
    {
        return $this->film_id;
    }

    public function setFilmId(Films $film_id): static
    {
        $this->film_id = $film_id;

        return $this;
    }

    public function getDureeFilm(): int
    {
        return $this->duree_film;
    }

    public function setDureeFilm(int $duree_film): static
    {
        $this->duree_film = $duree_film;
        return $this;
    }

    public function getSalleId(): Salles
    {
        return $this->salle_id;
    }

    public function setSalleId(Salles $salle_id): static
    {
        $this->salle_id = $salle_id;

        return $this;
    }

    public function getCinemaId(): ?int
    {
        return $this->cinema_id;
    }

    public function setCinemaId(int $cinema_id): static
    {
        $this->cinema_id = $cinema_id;

        return $this;
    }
}
