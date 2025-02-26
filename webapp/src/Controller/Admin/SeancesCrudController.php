<?php

namespace App\Controller\Admin;

use App\Entity\Films;
use App\Entity\Cinemas;
use App\Entity\Seances;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class SeancesCrudController extends AbstractCrudController
{
	private $cinemasRepository;
	private $filmsRepository;
	private $duree_film;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->cinemasRepository = $entityManager->getRepository(Cinemas::class);
		$this->filmsRepository = $entityManager->getRepository(Films::class);
	}

    public static function getEntityFqcn(): string
    {
        return Seances::class;
    }



    public function configureFields(string $pageName): iterable
    {

	    $cinemasValues = $this->cinemasRepository->findAll();

	    $choix_cinemas = [];
	    foreach ($cinemasValues as $cinema) {
		    $choix_cinemas[$cinema->getNom()] = $cinema->getId(); // Adapte cela à tes propriétés
	    }


	    return [
	        ChoiceField::new('cinema_id', 'Cinéma')->setChoices($choix_cinemas)->setColumns(4),
	        AssociationField::new('salle_id', 'Salle')->setColumns(3),
	        AssociationField::new('film_id', 'Film')
		        ->setFormTypeOptions([
			        'query_builder' => function (EntityRepository $er) {
				        return $er->createQueryBuilder('f')
					        ->orderBy('f.date_ajout', 'DESC');
			        },
		        ]),
	        HiddenField::new('duree_film'),
	        DateTimeField::new('date_debut', 'Date et heure de début')->setColumns(3),
	        DateTimeField::new('date_fin', "Date et heure de fin")->setColumns(3)
		        ->setFormTypeOption('attr', ["readonly"=>true]), // On désactive le champ pour que l'utilisateur ne puisse pas le modifier,
        ];
    }


}
