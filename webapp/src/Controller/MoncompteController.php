<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\MesInfosFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class MoncompteController extends AbstractController
{
    #[Route('/mon-compte', name: 'page_mon_compte')]
    //public function render_mon_compte(CalendrierRepository $calendrierRepository): Response
    public function render_mon_compte(): Response
    {

	    $reservations = array(
		    array("numero"=>"r20250212141715-03", "date_reservation"=>"2025-02-12 14:17:15", "date_seance"=>"2025-02-16 17:00:00", "film"=>"Captain America: Brave New World", "film_duree"=>"1h58"),
		    array("numero"=>"r20250208230205-01", "date_reservation"=>"2025-02-08 23:02:05", "date_seance"=>"2025-02-15 20:15:00", "film"=>"Sonic 3, le film", "film_duree"=>"1h49"),
		    array("numero"=>"r20250206102441-01", "date_reservation"=>"2025-02-06 10:24:41", "date_seance"=>"2025-02-08 20:15:00", "film"=>"Paddington au Pérou", "film_duree"=>"1h45"),
	    );

	    return $this->render('mon_compte.html.twig', [
		    'reservations' => $reservations,
	    ]);
    }

    #[Route('/mes_reservations', name: 'page_mes_reservations')]
    //public function render_mon_compte(CalendrierRepository $calendrierRepository): Response
    public function render_mes_reservations(): Response
    {

	    $reservations = array(
		    array("numero"=>"r20250212141715-03", "date_reservation"=>"2025-02-12 14:17:15", "date_seance"=>"2025-02-16 17:00:00", "film"=>"Captain America: Brave New World", "film_duree"=>"1h58"),
		    array("numero"=>"r20250208230205-01", "date_reservation"=>"2025-02-08 23:02:05", "date_seance"=>"2025-02-15 20:15:00", "film"=>"Sonic 3, le film", "film_duree"=>"1h49"),
		    array("numero"=>"r20250206102441-01", "date_reservation"=>"2025-02-06 10:24:41", "date_seance"=>"2025-02-08 20:15:00", "film"=>"Paddington au Pérou", "film_duree"=>"1h45"),
		    array("numero"=>"r20250101121052-02", "date_reservation"=>"2025-01-01 12:10:52", "date_seance"=>"2025-01-01 17:00:00", "film"=>"Un ours dans le Jura", "film_duree"=>"1h53"),
		    array("numero"=>"r20241218165247-04", "date_reservation"=>"2024-12-18 16:52:47", "date_seance"=>"2024-12-18 20:15:00", "film"=>"Mufasa : Le Roi Lion", "film_duree"=>"1h58"),
		    array("numero"=>"r20241127114524-01", "date_reservation"=>"2024-11-27 11:45:24", "date_seance"=>"2024-11-27 17:00:00", "film"=>"Vaiana 2", "film_duree"=>"1h39"),
	    );

	    return $this->render('mes_reservations.html.twig', [
		    'reservations' => $reservations,
	    ]);
    }


	#[Route('/mes_informations', name: 'page_mes_informations')]
	public function render_mes_informations(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
	{

		$user = $this->getUser();
		$form = $this->createForm(MesInfosFormType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			/** @var string $plainPassword */
			$plainPassword = $form->get('password')->getData();
			if ($plainPassword !== null) {
				// encode the plain password
				$user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
			}

			$entityManager->persist($user);
			$entityManager->flush();

			$this->addFlash('success', 'Vos nouvelles informations ont bien été enregistrées !');
			return $this->redirectToRoute('mes_informations');

		}

		return $this->render('mes_informations.html.twig', [
			'mesInfosForm' => $form,
		]);
	}
}
