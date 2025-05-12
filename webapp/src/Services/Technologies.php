<?php

namespace App\Services;

class Technologies
{
	public static function getTechnologies(): array
	{
		return [
			"imax"=>"IMAX",
			"4dx-ice"=>"4DX - ICE",
			"3d" => "3D",
			"onyx" => "ONYX",
		];
	}
}