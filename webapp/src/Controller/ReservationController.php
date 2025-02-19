<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\FilmsGenres;

class ReservationController extends AbstractController
{
	#[Route('/reservation', name: 'page_reservation', methods: ['GET'])]
	public function page_reservation(): Response
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

		return $this->render('reservation.html.twig', [
			'films' => $films,
			'genres' => $genres,
		]);
	}
	




}
