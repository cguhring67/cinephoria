<?php

namespace App\Controller\Admin;

use App\Entity\Films;
use App\Services\FilmsGenres;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class FilmsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Films::class;
    }

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->renderContentMaximized()
			//->setDateFormat('...')
			// ...
			;
	}

	public function configureFields(string $pageName): iterable
	{
		$films_genres = new FilmsGenres();
		$genres = $films_genres->getGenres();

		return [
			TextField::new('titre'),
			SlugField::new('affiche')->setTargetFieldName(['date_ajout', 'titre']),
			TextareaField::new('description')->setColumns(8),
			ChoiceField::new('genre')->setTranslatableChoices($genres)->allowMultipleChoices()->setColumns(4),
			TextField::new('realisateur')->setColumns(5),
			TextField::new('acteurs')->setColumns(7),
			IntegerField::new('age_mini')->setColumns(2),
			TimeField::new('duree')->setColumns(2),
			DateField::new('date_ajout')->setColumns(3),
			BooleanField::new('coup_de_coeur')->setColumns(3),
			TextareaField::new('avertissement')->setColumns(8),

		];
	}


}
