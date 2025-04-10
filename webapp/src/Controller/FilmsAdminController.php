<?php

namespace App\Controller;

use App\Entity\Films;
use App\Form\FilmsType;
use App\Repository\FilmsRepository;
use App\Services\FilmsGenres;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateInterval;


#[Route('/admin2/films')]
final class FilmsAdminController extends AbstractController
{
	#[Route(name: 'app_films_admin_index', methods: ['GET'])]
	public function index(FilmsRepository $filmsRepository): Response
	{
		$films_genres = new FilmsGenres();
		
		return $this->render('films_admin/index.html.twig', [
			'films' => $filmsRepository->findBy(
				array(),
				['date_ajout' => 'DESC']
			),
			'genres' => $films_genres->getGenres(),
		]);
	}
	
	#[Route('/new', name: 'app_films_admin_new', methods: ['GET', 'POST'])]
	public function new(Request $request, EntityManagerInterface $entityManager): Response
	{
		$film = new Films();
		
		$date_jour = new \DateTime("now");
		$date_mercredi = new \DateTime("now");
		$date_mercredi -> add(DateInterval::createFromDateString('next wednesday'));
		$nombre_jours = $date_mercredi->diff($date_jour)->days;
		if ($nombre_jours > 2)
		{
			$date_mercredi -> sub(DateInterval::createFromDateString('7 days'));
		}
		$date_mercredi = $date_mercredi->format('Y-m-d');
		$date_mercredi_immutable = new \DateTimeImmutable($date_mercredi);
		
		$film->setDateAjout($date_mercredi_immutable);
		$film->setAgeMini(0);
		
		$form = $this->createForm(FilmsType::class, $film);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->persist($film);
			$entityManager->flush();
			
			return $this->redirectToRoute('app_films_admin_index', [], Response::HTTP_SEE_OTHER);
		}
		
		return $this->render('films_admin/filmedit.html.twig', [
			'film' => $film,
			'form' => $form,
			'titrepage' => 'Ajouter un film',
		]);
	}
	
	
	#[Route('/{id}/edit', name: 'app_films_admin_edit', methods: ['GET', 'POST'])]
	public function edit(Request $request, Films $film, EntityManagerInterface $entityManager): Response
	{
		$form = $this->createForm(FilmsType::class, $film);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->flush();
			
			return $this->redirectToRoute('app_films_admin_index', [], Response::HTTP_SEE_OTHER);
		}
		
		return $this->render('films_admin/filmedit.html.twig', [
			'film' => $film,
			'form' => $form,
			'titrepage' => 'Modifier film',
		]);
	}
	
	#[Route('/{id}', name: 'app_films_admin_delete', methods: ['POST'])]
	public function delete(Request $request, Films $film, EntityManagerInterface $entityManager): Response
	{
		if ($this->isCsrfTokenValid('delete'.$film->getId(), $request->getPayload()->getString('_token'))) {
			$entityManager->remove($film);
			$entityManager->flush();
		}
		
		return $this->redirectToRoute('app_films_admin_index', [], Response::HTTP_SEE_OTHER);
	}
}
