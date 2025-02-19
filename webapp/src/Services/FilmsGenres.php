<?php

namespace App\Services;

class FilmsGenres
{

	public function getGenres(): array
	{
		$genres = [
			"Action",
			"Animation",
			"Arts Martiaux",
			"Aventure",
			"Biopic",
			"Comédie",
			"Comédie dramatique",
			"Comédie musicale",
			"Documentaire",
			"Drame",
			"Epouvante-horreur",
			"Espionnage",
			"Famille",
			"Fantastique",
			"Historique",
			"Musical",
			"Opera",
			"Policier",
			"Romance",
			"Science fiction",
			"Thriller"
		];
		return $genres;
	}

}