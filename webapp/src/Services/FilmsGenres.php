<?php

namespace App\Services;

class FilmsGenres
{
	public static function getGenres(): array
	{
		return [
			"action"=>"Action",
			"animation"=>"Animation",
			"arts_martiaux" => "Arts Martiaux",
			"aventure" => "Aventure",
			"biopic" => "Biopic",
			"comedie" => "Comédie",
			"comedie_dramatique" => "Comédie dramatique",
			"comedie_musicale" => "Comédie musicale",
			"documentaire" => "Documentaire",
			"drame" => "Drame",
			"epouvante_horreur" => "Epouvante-horreur",
			"espionnage" => "Espionnage",
			"famille" => "Famille",
			"fantastique" => "Fantastique",
			"historique" => "Historique",
			"musical" => "Musical",
			"opera" => "Opera",
			"policier" => "Policier",
			"romance" => "Romance",
			"science_fiction" => "Science fiction",
			"thriller" => "Thriller"
		];
	}
	
	public static function getGenresValKey(): array
	{
		return [
			"Action" => "action",
			"Animation" => "animation",
			"Arts Martiaux" => "arts_martiaux",
			"Aventure" => "aventure",
			"Biopic" => "biopic",
			"Comédie" => "comedie",
			"Comédie dramatique" => "comedie_dramatique",
			"Comédie musicale" => "comedie_musicale",
			"Documentaire" => "documentaire",
			"Drame" => "drame",
			"Epouvante-horreur" => "epouvante_horreur",
			"Espionnage" => "espionnage",
			"Famille" => "famille",
			"Fantastique" => "fantastique",
			"Historique" => "historique",
			"Musical" => "musical",
			"Opera" => "opera",
			"Policier" => "policier",
			"Romance" => "romance",
			"Science fiction" => "science_fiction",
			"Thriller" => "thriller",
			];
	}
}