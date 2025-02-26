<?php

namespace App\Entity;

use App\Repository\CinemasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CinemasRepository::class)]
class Cinemas
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 50)]
	private string $nom;

	#[ORM\Column(length: 45)]
	private string $adresse1;

	#[ORM\Column(length: 45, nullable: true)]
	private ?string $adresse2 = null;

	#[ORM\Column(length: 5)]
	private string $cp;

	#[ORM\Column(length: 45)]
	private string $ville;

	#[ORM\Column]
	private array $technologies = [];

	/**
	 * @var Collection<int, Salles>
	 */
	#[ORM\OneToMany(targetEntity: Salles::class, mappedBy: 'cinema_id', orphanRemoval: true)]
	private Collection $salles;

	/**
	 * @var Collection<int, Tarifs>
	 */
	#[ORM\OneToMany(targetEntity: Tarifs::class, mappedBy: 'cinema_id')]
	private Collection $tarifs;

	public function __construct()
	{
		$this->salles = new ArrayCollection();
		$this->tarifs = new ArrayCollection();
	}

	public function __toString(): string
	{
		return $this->getNom();  // or some string field in your Vegetal Entity
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

	public function getNom(): string
	{
		return $this->nom;
	}

	public function setNom(string $nom): static
	{
		$this->nom = $nom;

		return $this;
	}

	public function getAdresse1(): string
	{
		return $this->adresse1;
	}

	public function setAdresse1(string $adresse1): static
	{
		$this->adresse1 = $adresse1;

		return $this;
	}

	public function getAdresse2(): ?string
	{
		return $this->adresse2;
	}

	public function setAdresse2(?string $adresse2): static
	{
		$this->adresse2 = $adresse2;

		return $this;
	}

	public function getCp(): string
	{
		return $this->cp;
	}

	public function setCp(string $cp): static
	{
		$this->cp = $cp;

		return $this;
	}

	public function getVille(): string
	{
		return $this->ville;
	}

	public function setVille(string $ville): static
	{
		$this->ville = $ville;

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

	/**
	 * @return Collection<int, Salles>
	 */
	public function getSalles(): Collection
	{
		return $this->salles;
	}

	public function addSalles(Salles $salles): static
	{
		if (!$this->salles->contains($salles)) {
			$this->salles->add($salles);
			$salles->setCinemaId($this);
		}

		return $this;
	}

	public function removeSalles(Salles $salles): static
	{
		if ($this->salles->removeElement($salles)) {
			// set the owning side to null (unless already changed)
			if ($salles->getCinemaId() === $this) {
				$salles->setCinemaId(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection<int, Tarifs>
	 */
	public function getTarifs(): Collection
	{
		return $this->tarifs;
	}

	public function addTarif(Tarifs $tarif): static
	{
		if (!$this->tarifs->contains($tarif)) {
			$this->tarifs->add($tarif);
			$tarif->setCinemaId($this);
		}

		return $this;
	}

	public function removeTarif(Tarifs $tarif): static
	{
		if ($this->tarifs->removeElement($tarif)) {
			// set the owning side to null (unless already changed)
			if ($tarif->getCinemaId() === $this) {
				$tarif->setCinemaId(null);
			}
		}

		return $this;
	}
}
