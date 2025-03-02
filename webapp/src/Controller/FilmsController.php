<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Films;
use App\Entity\Cinemas;
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

		$films_genres_service = new FilmsGenres();
		$films_genres = $films_genres_service->getGenres();

		$technologies_service = new Technologies();
		$technologies = $technologies_service->getTechnologies();
		$date1 = "now";
		//$date1 = "2025-02-27";

		$dates = [];
		$date_temp = new \DateTime($date1);
		$date_temp2 = new \DateTime("now");
		$date_temp2->add(DateInterval::createFromDateString('next tuesday'));
		$nombre_jours = $date_temp2->diff($date_temp)->days;

		for($i = 0; $i <= $nombre_jours; $i++) {

			$date_temp = new \DateTime($date1);
			$date_temp->add(new DateInterval('P' . $i . 'D'));
			$date = $date_temp->format('Y-m-d');
			$date_fr = ucfirst( IntlDateFormatter::formatObject($date_temp, "EEEE d MMMM", 'fr_FR') );

			if ($i == 0) $label = "Aujourd'hui";
			if ($i == 1) $label = "Demain";
			if ($i == 2) $label = $date_fr;
			if ($i == 3  && $nombre_jours > 3)
			{
				$label = "Jours suivants";
				$date = "jours_suivants";
			}
			else if ($i == 3  && $nombre_jours == 3) $label = $date_fr;
			$dates[$date] = $label;
			if ($i == 3  && $nombre_jours > 3) break;

		}

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

		$films_genres_service = new FilmsGenres();
		$films_genres = $films_genres_service->getGenres();

		$technologies_service = new Technologies();
		$technologies = $technologies_service->getTechnologies();

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
				$date_temp = new \DateTime("now");
				$date_temp2 = new \DateTime("now");
				$date_temp2->add(new DateInterval('P' . 3 . 'D'));
				$date_intervalle_1 = $date_temp->format('Y-m-d');

				$date_temp3 = new \DateTime("now");
				$date_temp3->add(DateInterval::createFromDateString('next tuesday'));
				$nombre_jours = $date_temp2->diff($date_temp)->days;

				$date_temp4 = new \DateTime("now");
				$date_temp4->add(new DateInterval('P' . $nombre_jours . 'D'));
				$date_intervalle_2 = $date_temp->format('Y-m-d');
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
				$date_temp = new \DateTime("now");
				$nombre_jours = $film->getDateAjout()->diff($date_temp)->days;

				$data[] = [
					'id' => $film->getId(),
					'titre' => $film->getTitre(),
					'date_ajout' => $film->getDateAjout()->format('Y-m-d'),
					'nombre_jours' => $nombre_jours,
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
