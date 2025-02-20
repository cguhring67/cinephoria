<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
