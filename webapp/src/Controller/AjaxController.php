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





}
