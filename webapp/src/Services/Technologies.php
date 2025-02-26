<?php

namespace App\Services;

class Technologies
{

	public function getTechnologies(): array
	{
		$technologies = [
			"imax"=>"IMAX",
			"4dx-ice"=>"4DX - ICE",
			"3d" => "3D",
			"onyx" => "ONYX",
		];
		return $technologies;
	}

}