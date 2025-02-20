<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\FilmsGenres;

class FilmsController extends AbstractController
{
	#[Route('/films', name: 'liste_films', methods: ['GET'])]
	public function liste_films(): Response
	{
		
		$films = array(
			"bridget_jones_folle_de_lui",
			"captain_america",
			"daffy_et_porky_sauvent_le_monde",
			"god_save_the_tuche",
			"jouer_avec_le_feu",
			"la_pie_voleuse",
			"le_dernier_souffle",
			"le_mohican",
			"mufasa_le_roi_lion",
			"paddington_au_perou",
			"sonic3",
			"the_brutalist",
			"un_ours_dans_le_jura",
			"un_parfait_inconnu",
			"une_nuit_au_zoo",
			"vaiana2"
		);

		$films_genres = new FilmsGenres();
		$genres = $films_genres->getGenres();

		return $this->render('films.html.twig', [
			'films' => $films,
			'genres' => $genres,
		]);
	}
	
	#[Route('/film/{titre_film}', name: 'film_details', methods: ['GET'])]
	public function film_details($titre_film): Response
	{
		
		$films = array(
			"bridget_jones_folle_de_lui",
			"captain_america",
			"daffy_et_porky_sauvent_le_monde",
			"god_save_the_tuche",
			"jouer_avec_le_feu",
			"la_pie_voleuse",
			"le_dernier_souffle",
			"le_mohican",
			"mufasa_le_roi_lion",
			"paddington_au_perou",
			"sonic3",
			"the_brutalist",
			"un_ours_dans_le_jura",
			"un_parfait_inconnu",
			"une_nuit_au_zoo",
			"vaiana2"
		);
		
		
		return $this->render('film_details.html.twig', [
			'film' => $titre_film,
		]);
	}




}
