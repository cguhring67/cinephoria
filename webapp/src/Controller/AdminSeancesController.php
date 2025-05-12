<?php

namespace App\Controller;

use App\Entity\Cinemas;
use App\Entity\Films;
use App\Entity\Salles;
use App\Entity\Seances;
use App\Entity\User;
use App\Repository\SeancesRepository;
use App\Services\PlanningService;
use App\Services\DatesService;
use App\Services\Technologies;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin2/seances')]
class AdminSeancesController extends AbstractController
{
	private $entityManager;
	private $cinemasRepository;
	private $sallesRepository;
	private $filmsRepository;
	private $seancesRepository;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->cinemasRepository = $entityManager->getRepository(Cinemas::class);
		$this->sallesRepository = $entityManager->getRepository(Salles::class);
		$this->filmsRepository = $entityManager->getRepository(Films::class);
		$this->seancesRepository = $entityManager->getRepository(Seances::class);
	}
	
	#[Route(name: 'app_seances_admin_index', methods: ['GET'])]
	public function index(): Response
	{

		$technologies_service = new Technologies();
		$technologies = $technologies_service->getTechnologies();

		$data_cinemas = [];
		$cinemasValues = $this->cinemasRepository->findAll();
		foreach ($cinemasValues as $cinema)
		{
			$cinema_nom = str_replace("Cinephoria ", "", $cinema->getNom());
			$data_cinemas[$cinema->getId()] = $cinema_nom;
		}

		$data_salles = [];
		$salles = $this->sallesRepository->findBy(['cinema_id' => 1]);
		foreach ($salles as $salle)
		{
			$data_salles[] = [
				'id' => $salle->getId(),
				'nom' => $salle->getSalleNom(),
			];
		}

		$data_films = [];
		$films = $this->filmsRepository->findBy(
			array(),
			['date_ajout' => 'DESC']
		);
		foreach ($films as $film)
		{
			$anciennete = $film->getAnciennete();
			$film_duree = $film->getDureeStr();

			$data_films[] =
			[
				'id' => $film->getId(),
				'titre' => $film->getTitre(),
				'affiche' => $film->getAffiche(),
				'anciennete' => $anciennete,
				'duree' => $film_duree,
				'duree_minutes' => $film->getDureeMinutes(),
			];
		}

		$planning_service = new PlanningService($this->entityManager);
		$seances = $planning_service->getPlanningJson(1, "now");

		$dates = DatesService::listeDatesJusquaMardi("planning");

		return $this->render('admin/seances_planning.html.twig',
		[
			'dates' => $dates,
			'technologies' => $technologies,
			'cinemas' => $data_cinemas,
			'salles' => $data_salles,
			'data_films' => $data_films,
			'seances' => $seances,
		]);
	}
	
	#[Route('/ajax/', name: 'seances_ajax', methods: ['GET', 'POST'])]
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
				$response->setContent($seancesJson);
				$response->headers->set('Content-Type', 'application/json');
			}
			
			if ($mode == 'save_planning' || $mode == 'save_planning_and_copy')
			{
				$planning_json = $data['planning'];
				
				$cinema_id = intval($data['cinema_id']);
				$choix_date = $data['choix_date'];
				$entityManager = $this->entityManager;
				
				foreach ($planning_json as $planning_salles)
				{
					$salle_id = intval($planning_salles['salle_id']);
					$salle_planning = $planning_salles['schedule'];
					
					foreach ($salle_planning as $planning_seance)
					{
						$seance_id = intval($planning_seance['data']['seance_id'] ?? 0);
						$film_id = intval($planning_seance['data']['film_id']);
						$techno = [$planning_seance['data']['technos']];
						
						$heure_debut = explode(":", $planning_seance['start']);
						$heure_fin = explode(":", $planning_seance['end']);
						
						$date_debut = new \DateTime($choix_date);
						$date_fin = new \DateTime($choix_date);
						$date_debut->setTime(intval($heure_debut[0]), intval($heure_debut[1]));
						$date_fin->setTime(intval($heure_fin[0]), intval($heure_fin[1]));
						
						if ($seance_id > 0) $seance = $entityManager->getRepository(Seances::class)->find($seance_id);
						else $seance = new Seances();
						
						$seance->setCinemaId($cinema_id);
						$seance->setSalleId($entityManager->getRepository(Salles::class)->find($salle_id));
						$seance->setFilmId($entityManager->getRepository(Films::class)->find($film_id));
						$seance->setDateDebut($date_debut);
						$seance->setDateFin($date_fin);
						$seance->setTechnologies($techno);
						
						$entityManager->persist($seance);
					}
				}
				$entityManager->flush();
				$response = new Response("Séances enregistrées avec success");
			}
			
			if ($mode == 'delete_seance')
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
			
			return $response;
		}
		return new Response("['error' => 'Cet appel doit être effectué via AJAX.']", Response::HTTP_BAD_REQUEST);
	}
	
	
	
	
}
