<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
	#[Route('/', name: 'index', methods: ['GET'])]
	public function index(): Response
	{
		
		$films = array(
			"images/affiches/bridget_jones_folle_de_lui.jpg",
			"images/affiches/captain_america.jpg",
			"images/affiches/daffy_et_porky_sauvent_le_monde.jpg",
			"images/affiches/god_save_the_tuche.jpg",
			"images/affiches/jouer_avec_le_feu.jpg",
			"images/affiches/la_pie_voleuse.jpg",
			"images/affiches/le_dernier_souffle.jpg",
			"images/affiches/le_mohican.jpg",
			"images/affiches/mufasa_le_roi_lion.jpg",
			"images/affiches/paddington_au_perou.jpg",
			"images/affiches/sonic3.jpg",
			"images/affiches/the_brutalist.jpg",
			"images/affiches/un_ours_dans_le_jura.jpg",
			"images/affiches/un_parfait_inconnu.jpg",
			"images/affiches/une_nuit_au_zoo.jpg",
			"images/affiches/vaiana2.jpg"
		);
		
		
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
	public function page_cinemas(): Response
	{
		return $this->render('cinemas.html.twig');
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


}
