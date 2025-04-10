<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Films;
use App\Entity\Seances;
use App\Entity\Salles;
use App\Repository\FilmsRepository;
use App\Repository\SallesRepository;
use App\Repository\SeancesRepository;
use App\Services\PlanningService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class AjaxController extends AbstractController
{

	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	#[Route('/admin/salles/salles_by_cinema/{cinema_id}', name: 'get_salles_by_cinema_id', methods: ['GET'])]
	public function getSallesByCinema(SallesRepository $sallesRepository, $cinema_id): JsonResponse
	{
		$salles = $sallesRepository->findBy(['cinema_id' => $cinema_id]);

		$data = [];
		foreach ($salles as $salle) {
			$data[] = [
				'id' => $salle->getId(),
				'nom' => $salle->getSalleNom(),
			];
		}

		return new JsonResponse($data);
	}

	#[Route('/admin/films/duree_film/{film_id}', name: 'get_duree_film', methods: ['GET'])]
	public function getDureeFilm(FilmsRepository $filmsRepository, $film_id): JsonResponse
	{
		$film = $filmsRepository->find($film_id);
		$data[] = [
			'duree_film' => $film->getDureeMinutes(),
		];

		return new JsonResponse($data);
	}


	#[Route('/admin/seances_ajax/', name: 'seances_ajax', methods: ['GET', 'POST'])]
	public function seances_ajax(Request $request, SeancesRepository $seancesRepository): Response
	{

		if($request->isXmlHttpRequest()) {
			$data = json_decode($request->getContent(), true);
			$message = "Requête AJAX OK";

			$mode = $data['mode'];
			$response = new Response();

			if ($mode == 'search_cinema_date')
			{
				$search_date = $data['search_date'];
				$search_cinema = $data['search_cinema'];
				$planning_service = new PlanningService($this->entityManager);
				$seancesJson = $planning_service->getPlanningJson($search_cinema, $search_date);
				//dd($seancesJson);
				$response->setContent($seancesJson);
				$response->headers->set('Content-Type', 'application/json');
			}
			if ($mode == 'save_planning')
			{
				$planning_json = $data['planning'];
				//dd($data);

				foreach ($planning_json as $planning_seance)
				{
					$seance_cinema = $data['cinema_id'];
					$seance_date = $data['choix_date'];

					$seance_id = $planning_seance['data']['seance_id'];
					$seance_film = $planning_seance['data']['film_id'];
					$seance_salle = $planning_seance['salle_id'];
					$seance_start = $planning_seance['start'];
					$seance_end = $planning_seance['end'];

				}

			}

			if ($mode == 'nouvelle_seance')
			{
				$salle_id = intval($data['salle_id']);
				$choix_date = $data['choix_date'];
				$cinema_id = intval($data['cinema_id']);
				$film_id = intval($data['film_id']);
				$techno = [$data['techno']];
				$heure_debut = explode(":", $data['heure_debut']);
				$heure_fin = explode(":", $data['heure_fin']);

				$date_debut = new \DateTime($choix_date);
				$date_fin = new \DateTime($choix_date);
				$date_debut->setTime(intval($heure_debut[0]), intval($heure_debut[1]));
				$date_fin->setTime(intval($heure_fin[0]), intval($heure_fin[1]));

				$entityManager = $this->entityManager;
				$salle = $entityManager->getRepository(Salles::class)->find($salle_id);
				$film = $entityManager->getRepository(Films::class)->find($film_id);


				$seance = new Seances();
				$seance->setSalleId($salle);
				$seance->setCinemaId($cinema_id);
				$seance->setFilmId($film);
				$seance->setDateDebut($date_debut);
				$seance->setDateFin($date_fin);
				$seance->setTechnologies($techno);

				$entityManager->persist($seance);
				$entityManager->flush();

//				dd($seance);
				$response = new Response("Séance enregistrée avec success");

			}




			if ($mode == 'delete_event')
			{
				$planning_json = $data['data'];
				$seance_a_supprimer = $data['data']['data']['seance_id'];

				$entityManager = $this->entityManager;
				$seance = $entityManager->getRepository(Seances::class)->find($seance_a_supprimer);

				if (!$seance) {
					throw $this->createNotFoundException('Pas de séance trouvée avec cette id : '.$seance_a_supprimer);
				}

				$entityManager->remove($seance);
				$entityManager->flush();
				$response = new Response("Séance " . $seance_a_supprimer . " supprimée.");

			}


			if ($mode == 'update_seance')
			{
				$planning_json = $data['data'];
				$seance_id = $data['data']['data']['seance_id'];

				$salle_id = intval($data['salle_id']);
				$choix_date = $data['choix_date'];
				$techno = [$data['techno']];
				$heure_debut = explode(":", $data['heure_debut']);
				$heure_fin = explode(":", $data['heure_fin']);

				$date_debut = new \DateTime($choix_date);
				$date_fin = new \DateTime($choix_date);
				$date_debut->setTime(intval($heure_debut[0]), intval($heure_debut[1]));
				$date_fin->setTime(intval($heure_fin[0]), intval($heure_fin[1]));

				$entityManager = $this->entityManager;
				$salle = $entityManager->getRepository(Salles::class)->find($salle_id);
				$seance = $entityManager->getRepository(Seances::class)->find($seance_a_supprimer);

				$seance->setSalleId($salle);
				$seance->setDateDebut($date_debut);
				$seance->setDateFin($date_fin);
				$seance->setTechnologies($techno);

				$entityManager->persist($seance);
				$entityManager->flush();

			}

			return $response;
		}
		return new Response("['error' => 'Cet appel doit être effectué via AJAX.']", Response::HTTP_BAD_REQUEST);

	}



}
