<?php

namespace App\Form;

use App\Entity\Films;
use App\Services\FilmsGenres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class FilmsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
	    $films_genres = new FilmsGenres();
	    $genres = $films_genres->getGenresValKey();
	    
	    $builder
			->add('save', SubmitType::class)
//			->add('save_and_stay', SubmitType::class)
			->add('titre')
			->add('affiche')
			->add('genre', ChoiceType::class, [
			   'choices'  => $genres,
			   'multiple' => true,
			   'expanded' => false,
			   'autocomplete' => true,
			])
			->add('age_mini')
			->add('coup_de_coeur', CheckboxType::class, [
				'required' => false,
				
			])
			//->add('score')
			->add('duree', TimeType::class, [
			    'widget' => 'single_text',
			])
			->add('date_ajout', DateType::class, [
			    'widget' => 'single_text',
			])
			->add('realisateur')
			->add('acteurs')
			->add('description', TextareaType::class, [
			    'attr' => ['rows' => '4'],
			])
			->add('avertissement', TextareaType::class, [
			   'attr' => ['rows' => '4'],
				'required' => false,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Films::class,
        ]);
    }
}
