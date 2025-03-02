<?php

namespace App\Services;

class FilmsGenres
{

	public function getGenres(): array
	{
		$genres = [
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
		return $genres;
	}

}