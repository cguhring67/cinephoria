<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Films;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\FilmsGenres;
use App\Repository\FilmsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

class FilmsController extends AbstractController
{
	#[Route('/films', name: 'liste_films', methods: ['GET'])]
	public function liste_films(FilmsRepository $filmsRepository): Response
	{

		$films = $filmsRepository->findBy(
			array(),
			['date_ajout' => 'DESC']
		);

		$films_genres = new FilmsGenres();
		$genres = $films_genres->getGenres();

		return $this->render('films.html.twig', [
			'films' => $films,
			'genres' => $genres,
		]);
	}
	
	#[Route('/film/{id}', name: 'film_details', methods: ['GET'])]
	public function film_details(RouterInterface $router, Films $film): Response
	{

		return $this->render('film_details.html.twig', [
			'film' => $film,
		]);
	}




}
