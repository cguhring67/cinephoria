<?php

namespace App\Services;

use App\Entity\Salles;
use App\Entity\Seances;
use Doctrine\ORM\EntityManagerInterface;


class PlanningService
{

	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function getPlanningJson($cinema_id = 1, $date_search = "now"): string
	{
//		$this->entityManager = new EntityManagerInterface;

		$salles = $this->entityManager->getRepository(Salles::class)->findBy(['cinema_id' => $cinema_id]);
		$planning = [];
		$json = "";

		$index = 0;

		foreach ($salles as $salle) {
			$schedule = [];
			$seances = $this->entityManager->getRepository(Seances::class)->findByDateAndsalle($salle, $date_search);

			foreach ($seances as $seance)
			{
				$schedule[] = [
					'start' => $seance->getDateDebut()->format('H:i'),
					'end' => $seance->getDateFin()->format('H:i'),
					'text' => $seance->getFilmId()->getTitre(),
					'data' => [
						'seance_id' => $seance->getId(),
						'class' => ($seance->getFilmId()->getAnciennete() < 7) ? "nouveau" : "",
						'image' => '/images/affiches/' . $seance->getFilmId()->getAffiche() . '.jpg',
						'film_id' => $seance->getFilmId()->getId(),
						'salle_id' => $salle->getId(),
						'technos' => $seance->getTechnologies(),
					],
				];
			}

			$planning[$index] = [
				'title' => $salle->getSalleNom(),
				'subtitle' => '', // Vous pouvez adapter ici
				'schedule' => $schedule,
			];
			$json .= "'$index': " .json_encode($planning[$index]).",";

			$index++;
		}

		return $json;
	}

}