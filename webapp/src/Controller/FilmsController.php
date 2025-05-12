<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Films;
use App\Entity\Cinemas;
use App\Services\DatesService;
use DateInterval;
use IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\FilmsGenres;
use App\Services\Technologies;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

class FilmsController extends AbstractController
{
	#[Route('/films', name: 'liste_films', methods: ['GET'])]
	public function liste_films(EntityManagerInterface $entityManager): Response
	{

		$cinemas = $entityManager->getRepository(Cinemas::class)->findBy(
			array(),
			['ville' => 'ASC']
		);

		$films_par_seances_du_jour = $entityManager->getRepository(Films::class)->findFilmsByFiltres("now", "now", "", "", "");

		$films_genres = FilmsGenres::getGenres();
		$technologies = Technologies::getTechnologies();
		
		$dates = DatesService::listeDatesJusquaMardi("films");

		return $this->render('films.html.twig', [
			'films' => $films_par_seances_du_jour,
			'cinemas' => $cinemas,
			'genres' => $films_genres,
			'technologies' => $technologies,
			'dates' => $dates,
		]);
	}
	
	#[Route('/film/{id}', name: 'film_details', methods: ['GET'])]
	public function film_details(RouterInterface $router, Films $film): Response
	{

		$films_genres = FilmsGenres::getGenres();
		$technologies = Technologies::getTechnologies();

		return $this->render('film_details.html.twig', [
			'film' => $film,
			'genres' => $films_genres,
			'technologies' => $technologies,
		]);
	}



	#[Route('/films_ajax/', name: 'films_ajax', methods: ['GET', 'POST'])]
	public function test(Request $request, EntityManagerInterface $entityManager): JsonResponse|Response
	{

		if($request->isXmlHttpRequest()) {
			$data = json_decode($request->getContent(), true);
			$message = "Requête AJAX OK";

			$search_date = $data['search_date'];
			$search_cinema = $data['search_cinema'];
			$search_technologie = $data['search_technologie'];
			$search_genre = $data['search_genre'];

			if ($search_date == "jours_suivants")
			{
				$dates_service = new DatesService();
				$dates = $dates_service->getIntervalFrom3DaysToNextTuesday();
				$date_intervalle_1 = $dates[0];
				$date_intervalle_2 = $dates[1];
			}
			else
			{
				$date_intervalle_1 = $date_intervalle_2 = $search_date;

			}
			if ($search_genre == "tous") $search_genre = "";
			if ($search_technologie == "tous") $search_technologie = "";
			if ($search_cinema == "tous") $search_cinema = "";

			$films_par_seances_du_jour = $entityManager
				->getRepository(Films::class)
				->findFilmsByFiltres(
					"$date_intervalle_1",
					"$date_intervalle_2",
					"$search_genre",
					"$search_technologie",
					"$search_cinema"
				);
//			dd($films_par_seances_du_jour);
			$data = [];
			foreach($films_par_seances_du_jour as $film)
			{
				$nombre_jours_anciennete = DatesService::getDaysUntilToday($film->getDateAjout());

				$data[] = [
					'id' => $film->getId(),
					'titre' => $film->getTitre(),
					'affiche' => $film->getAffiche(),
					'date_ajout' => $film->getDateAjout()->format('Y-m-d'),
					'nombre_jours' => $nombre_jours_anciennete,
					'coup_de_coeur' => $film->getCoupDeCoeur(),
					'age_mini' => $film->getAgeMini(),
					'avertissement' => $film->getAvertissement(),
				];
			}

//			$json_response = json_encode($data);
//
			return new JsonResponse($data);
		}
		return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);

	}



}
