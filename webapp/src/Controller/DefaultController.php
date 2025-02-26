<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Salles;
use App\Repository\CinemasRepository;
use App\Repository\SallesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FilmsRepository;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController
{
	#[Route('/', name: 'index', methods: ['GET'])]
	public function index(FilmsRepository $filmsRepository): Response
	{

		$films = $filmsRepository->findAll();
		dump($films);

		return $this->render('accueil.html.twig', [
			'films' => $films,
		]);
	}


	#[Route('/a_propos', name: 'apropos', methods: ['GET'])]
	public function page_apropos(): Response
	{
		return $this->render('apropos.html.twig');
	}

	#[Route('/cinemas', name: 'cinemas', methods: ['GET'])]
	public function page_cinemas(CinemasRepository $cinemasRepository): Response
	{
		$cinemas = $cinemasRepository->findAll();
		return $this->render('cinemas.html.twig', [
			'cinemas' => $cinemas,
		]);
	}

	#[Route('/technologies', name: 'technologies', methods: ['GET'])]
	public function page_technologies(): Response
	{
		return $this->render('technologies.html.twig');
	}

	#[Route('/mentions_legales', name: 'mentions_legales', methods: ['GET'])]
	public function page_mentions(): Response
	{
		return $this->render('mentions_legales.html.twig');
	}

	#[Route('/politique_de_confidentialite', name: 'confidentialite', methods: ['GET'])]
	public function page_confidentialite(): Response
	{
		return $this->render('confidentialite.html.twig');
	}

	#[Route('/contact', name: 'contact', methods: ['GET'])]
	public function page_contact(): Response
	{
		return $this->render('contact.html.twig');
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

}
