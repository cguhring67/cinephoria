<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Entity\Cinemas;
use App\Entity\Films;
use App\Entity\Salles;
use App\Entity\Seances;
use App\Entity\Tarifs;
use App\Entity\User;
use App\Services\PlanningService;
use App\Services\Technologies;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateInterval;
use IntlDateFormatter;


#[AdminDashboard(routePath: '/admin/seances_planning', routeName: 'seances_planning')]
class SeancesPlanningController extends AbstractDashboardController
{

	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->cinemasRepository = $entityManager->getRepository(Cinemas::class);
		$this->sallesRepository = $entityManager->getRepository(Salles::class);
		$this->filmsRepository = $entityManager->getRepository(Films::class);
		$this->seancesRepository = $entityManager->getRepository(Seances::class);
	}

	public function index(): Response
	{

		$technologies_service = new Technologies();
		$technologies = $technologies_service->getTechnologies();

		$data_cinemas = [];
		$cinemasValues = $this->cinemasRepository->findAll();
		foreach ($cinemasValues as $cinema)
		{
			$cinema_nom = str_replace("Cinephoria ", "", $cinema->getNom());
			$data_cinemas[$cinema->getId()] = $cinema_nom;
		}

		$data_salles = [];
		$salles = $this->sallesRepository->findBy(['cinema_id' => 1]);
		foreach ($salles as $salle)
		{
			$data_salles[] = [
				'id' => $salle->getId(),
				'nom' => $salle->getSalleNom(),
			];
		}

		$data_films = [];
		$films = $this->filmsRepository->findBy(
			array(),
			['date_ajout' => 'DESC']
		);
		foreach ($films as $film)
		{
			$anciennete = $film->getAnciennete();
			$film_duree = $film->getDureeStr();

			$data_films[] =
			[
				'id' => $film->getId(),
				'titre' => $film->getTitre(),
				'affiche' => $film->getAffiche(),
				'anciennete' => $anciennete,
				'duree' => $film_duree,
				'duree_minutes' => $film->getDureeMinutes(),
			];
		}

		$planning_service = new PlanningService($this->entityManager);
		$data_seances = [];
		$seances = $planning_service->getPlanningJson(1, "now");

		$dates = [];
		$date_temp = new \DateTime("now");
		$date_temp2 = new \DateTime("now");
		$date_temp2->add(DateInterval::createFromDateString('next tuesday'));
		$nombre_jours = $date_temp2->diff($date_temp)->days;

		for($i = 0; $i <= $nombre_jours; $i++) {

			$date_temp = new \DateTime("now");
			$date_temp->add(new DateInterval('P' . $i . 'D'));
			$date = $date_temp->format('Y-m-d');
			$date_fr = ucfirst( IntlDateFormatter::formatObject($date_temp, "EEEE d MMMM", 'fr_FR') );

			if ($i == 0) $label = "Aujourd'hui";
			if ($i == 1) $label = "Demain";
			if ($i >= 2) $label = $date_fr;

			$dates[$date] = $label;

		}



//		dump($data_cinemas);
//		dd($data_seances);
		return $this->render('admin/seances_planning.html.twig',
		[
			'dates' => $dates,
			'technologies' => $technologies,
			'cinemas' => $data_cinemas,
			'salles' => $data_salles,
			'data_films' => $data_films,
			'seances' => $seances,
		]);
	}

	public function configureDashboard(): Dashboard
	{
		return Dashboard::new()
			->setTitle('<h4 class="text-center"><img src="/images/logo_cinephoria_trans.png"><br>Administration</h4>');
	}

	public function configureMenuItems(): iterable
	{
		yield MenuItem::linkToUrl('Tableau de bord', 'fa fa-home', '/admin/');
		yield MenuItem::linkToUrl('Retour au site', 'fa fa-home', '/');
		yield MenuItem::section();
		yield MenuItem::linkToCrud('Cinemas', 'fas fa-hotel', Cinemas::class);
		yield MenuItem::linkToCrud('Salles', 'fas fa-couch', Salles::class);
		yield MenuItem::linkToCrud('Films', 'fas fa-film', Films::class);
		yield MenuItem::linkToCrud('Séances', 'fas fa-video', Seances::class);
		yield MenuItem::linkToDashboard('Planning Séances', 'fa fa-home');
		//yield MenuItem::linkToUrl('Planning Séances', 'far fa-calendar-days', '/admin/seances_planning');
		yield MenuItem::linkToCrud('Avis', 'far fa-comment-dots', Avis::class);
		yield MenuItem::linkToCrud('Tarifs', 'fas fa-coins', Tarifs::class);
		yield MenuItem::linkToCrud('Réservations', 'fas fa-ticket', Tarifs::class);
		yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
	}


	public function configureAssets(): Assets
	{
		return Assets::new()
			->addCssFile('css/admin.css')
			->addJsFile('js/admin.js');
	}


}
