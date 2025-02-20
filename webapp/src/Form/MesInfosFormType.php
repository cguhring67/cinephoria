<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class MesInfosFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nom', TextType::class, [
				'label' => 'Votre nom :',
				'required' => true,
				'constraints' => [
					new NotBlank([
						'message' => 'Veuillez entrer un nom.',
					]),
					new Length([
						'min' => 3,
						'minMessage' => "Veuillez renseigner un nom d'au-moins {{ limit }} caractères."
					]),
				]
			])
			->add('prenom', TextType::class, [
				'label' => 'Votre prénom :',
				'required' => true,
				'constraints' => [
					new NotBlank([
						'message' => 'Veuillez entrer un prénom.',
					]),
					new Length([
						'min' => 3,
						'minMessage' => "Veuillez renseigner un prénom d'au-moins {{ limit }} caractères.",
					]),
				]
			])
			->add('email', EmailType::class, [
				'label' => 'Votre email :',
				'required' => true,
				'constraints' => [
					new NotBlank([
						'message' => 'Veuillez entrer une adresse email.',
					]),
					new Email([
						'message' => 'Veuillez entrer une adresse email valide.',
					])
				]
			])
			->add('password', PasswordType::class, [
				// instead of being set onto the object directly,
				// this is read and encoded in the controller
				'mapped' => false,
				'label' => 'Nouveau mot de passe :',
				'attr' => ['autocomplete' => 'new-password'],
				'constraints' => [
					new passwordStrength([
						'minScore' => PasswordStrength::STRENGTH_WEAK,
						'message' => "Votre mot de passe n'est pas assez compliqué et trop facile à deviner. Votre mot de passe doit comporter entre 10 et 20 caractères, et être composé d'au moins une majuscule, des minuscules, un chiffre et un caractères spécial.",
					]),
					new NotCompromisedPassword([
						'message' => 'Ce mot de passe a fuité dans une faille de sécurité et ne doit pas être utilisé !',
					])
				],
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => User::class,
		]);

	}
}
