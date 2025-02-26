<?php

namespace App\Controller\Admin;

use App\Entity\Salles;
use App\Services\Technologies;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminAction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class SallesCrudController extends AbstractCrudController
{
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

		public static function getEntityFqcn(): string
    {
        return Salles::class;
    }



    public function configureFields(string $pageName): iterable
    {
		 $technologies_service = new Technologies();
	    $technologies = $technologies_service->getTechnologies();

        return [
	        TextField::new('salle_nom', 'Nom de la salle'),
	        AssociationField::new('cinema_id', 'Cinéma'),
	        IntegerField::new('places', 'Nombre de places')->setColumns(2),
	        ChoiceField::new('technologies', 'Technologies')->setTranslatableChoices($technologies)->allowMultipleChoices()->setColumns(4),

        ];
    }
}
