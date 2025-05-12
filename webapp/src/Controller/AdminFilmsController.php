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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use DateInterval;


#[Route('/admin2/films')]
final class AdminFilmsController extends AbstractController
{
	#[Route(name: 'app_films_admin_index', methods: ['GET'])]
	public function index(FilmsRepository $filmsRepository): Response
	{
		return $this->render('admin/films_list.html.twig', [
			'films' => $filmsRepository->findBy(
				array(),
				['date_ajout' => 'DESC', 'id' => 'DESC']
			),
			'genres' => FilmsGenres::getGenres(),
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
		$film->setAffiche("image_vide");
		
		$form = $this->createForm(FilmsType::class, $film);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->persist($film);
			$entityManager->flush();
			
			if ($form->get('save')->isClicked()) {
				return $this->redirectToRoute('app_films_admin_index', [], Response::HTTP_CREATED);
			}
			
		}
		
		return $this->render('admin/film_form.html.twig', [
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
			$entityManager->persist($film);
			$entityManager->flush();
			
			if ($form->get('save')->isClicked()) {
				return $this->redirectToRoute('app_films_admin_index', [], Response::HTTP_TEMPORARY_REDIRECT);
			}
		}
		
		return $this->render('admin/film_form.html.twig', [
			'film' => $film,
			'form' => $form,
			'titrepage' => 'Modifier film',
		]);
	}
	
	#[Route('/{id}/delete', name: 'app_films_admin_delete', methods: ['GET'])]
	public function delete(Request $request, Films $film, EntityManagerInterface $entityManager): Response
	{
		$entityManager->remove($film);
		$entityManager->flush();
		
		return $this->redirectToRoute('app_films_admin_index', [], Response::HTTP_SEE_OTHER);
	}
	
	
	
	
}
