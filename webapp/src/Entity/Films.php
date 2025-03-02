<?php

namespace App\Entity;

use App\Repository\FilmsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmsRepository::class)]
class Films
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 80)]
	private string $titre;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $affiche = null;

	#[ORM\Column(type: Types::TEXT)]
	private string $description;

	#[ORM\Column(type: Types::JSON)]
	private array $genre = [];

	#[ORM\Column]
	private ?int $age_mini = null;

	#[ORM\Column(nullable: true)]
	private ?int $coup_de_coeur = null;

	#[ORM\Column(nullable: true)]
	private ?int $score = null;

	#[ORM\Column(type: Types::TIME_MUTABLE)]
	private \DateTimeInterface $duree;

	#[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
	private \DateTimeImmutable $date_ajout;

	/**
	 * @var Collection<int, Avis>
	 */
	#[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'film_id', orphanRemoval: true)]
	private Collection $notes;

	/**
	 * @var Collection<int, Seances>
	 */
	#[ORM\OneToMany(targetEntity: Seances::class, mappedBy: 'film_id', orphanRemoval: true)]
	private Collection $seances;

	#[ORM\Column(length: 100, nullable: true)]
	private ?string $realisateur = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $acteurs = null;

	#[ORM\Column(length: 255, nullable: true)]
	private ?string $avertissement = null;

	public function __construct()
	{
		$this->notes = new ArrayCollection();
		$this->seances = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}


	public function __toString(): string
	{
		return $this->getTitre();
	}

	public function getTitre(): string
	{
		return $this->titre;
	}

	public function setTitre(string $titre): static
	{
		$this->titre = $titre;

		return $this;
	}

	public function getAffiche(): ?string
	{
		return $this->affiche;
	}

	public function setAffiche(?string $affiche): static
	{
		$this->affiche = $affiche;

		return $this;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public function setDescription(string $description): static
	{
		$this->description = $description;

		return $this;
	}

	public function getGenre(): array
	{
		return $this->genre;
	}

	public function setGenre(array $genre): static
	{
		$this->genre = $genre;

		return $this;
	}

	public function getAgeMini(): ?int
	{
		return $this->age_mini;
	}

	public function setAgeMini(int $age_mini): static
	{
		$this->age_mini = $age_mini;

		return $this;
	}

	public function getCoupDeCoeur(): bool
	{
		if ($this->coup_de_coeur === 1)
			return true;
		else
			return false;
	}

	public function setCoupDeCoeur(?int $coup_de_coeur): static
	{
		$this->coup_de_coeur = $coup_de_coeur;

		return $this;
	}

	public function getScore(): ?int
	{
		return $this->score;
	}

	public function setScore(?int $score): static
	{
		$this->score = $score;

		return $this;
	}

	public function getDuree(): ?\DateTimeInterface
	{
		return $this->duree;
	}

	public function getDureeMinutes(): int
	{
		return $this->duree->format('U') / 60;
	}

	public function setDuree(\DateTimeInterface $duree): static
	{
		$this->duree = $duree;

		return $this;
	}

	public function getDateAjout(): \DateTimeImmutable
	{
		return $this->date_ajout;
	}

	public function setDateAjout(\DateTimeImmutable $date_ajout): static
	{
		$this->date_ajout = $date_ajout;

		return $this;
	}

	/**
	 * @return Collection<int, Avis>
	 */
	public function getNotes(): Collection
	{
		return $this->notes;
	}

	public function addNote(Avis $note): static
	{
		if (!$this->notes->contains($note)) {
			$this->notes->add($note);
			$note->setFilmId($this);
		}

		return $this;
	}

	public function removeNote(Avis $note): static
	{
		if ($this->notes->removeElement($note)) {
			// set the owning side to null (unless already changed)
			if ($note->getFilmId() === $this) {
				$note->setFilmId(null);
			}
		}

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
			$seance->setFilmId($this);
		}

		return $this;
	}

	public function removeSeance(Seances $seance): static
	{
		if ($this->seances->removeElement($seance)) {
			// set the owning side to null (unless already changed)
			if ($seance->getFilmId() === $this) {
				$seance->setFilmId(null);
			}
		}

		return $this;
	}

	public function getRealisateur(): ?string
	{
		return $this->realisateur;
	}

	public function setRealisateur(?string $realisateur): static
	{
		$this->realisateur = $realisateur;

		return $this;
	}

	public function getActeurs(): ?string
	{
		return $this->acteurs;
	}

	public function setActeurs(?string $acteurs): static
	{
		$this->acteurs = $acteurs;

		return $this;
	}

	public function getAvertissement(): ?string
	{
		return $this->avertissement;
	}

	public function setAvertissement(?string $avertissement): static
	{
		$this->avertissement = $avertissement;

		return $this;
	}


}
