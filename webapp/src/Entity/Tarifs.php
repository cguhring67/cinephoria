<?php

namespace App\Entity;

use App\Repository\TarifsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifsRepository::class)]
class Tarifs
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 50)]
	private string $tarif_type;

	#[ORM\Column(length: 50)]
	private string $tarif_nom;

	#[ORM\Column]
	private int $tarif;

	#[ORM\ManyToOne(inversedBy: 'tarifs')]
	#[ORM\JoinColumn(nullable: false)]
	private Cinemas $cinema_id;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function __toString(): string
	{
		return $this->getTarifNom();  // or some string field in your Vegetal Entity
	}


	public function getTarifType(): string
	{
		return $this->tarif_type;
	}

	public function setTarifType(string $tarif_type): static
	{
		$this->tarif_type = $tarif_type;

		return $this;
	}

	public function getTarifNom(): string
	{
		return $this->tarif_nom;
	}

	public function setTarifNom(string $tarif_nom): static
	{
		$this->tarif_nom = $tarif_nom;

		return $this;
	}

	public function getTarif(): int
	{
		return $this->tarif;
	}

	public function setTarif(int $tarif): static
	{
		$this->tarif = $tarif;

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
}
