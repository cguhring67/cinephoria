<?php

namespace App\Services;

use DateInterval;
use \DateTime;
use IntlDateFormatter;


class DatesService
{
	/**
	 * @return DateTime
	 * Retourne la date du jour
	 */
		public static function getDatetimeNow(): DateTime
	{
//		return new DateTime("now");
		return new DateTime("2025-04-29");
	}
	
	
	/**
	 * @return array
	 * Retourne dans un tableau, deux dates au format Y-m-d. 1ère date : dans 3 jours, 2è date : prochain mardi
	 */
		public static function getIntervalFrom3DaysToNextTuesday(): array
	{
		$datetime_dans_3_jours = self::getDatetimeNow();
		$datetime_dans_3_jours->add(new DateInterval('P;' . 3 . 'D'));
		return [
			$datetime_dans_3_jours->format('Y-m-d'),
			self::getNextTuesday()->format('Y-m-d')
		];
	}
	
	/**
	 * @return DateTime
	 * Retourne la date du prochain mardi
	 */
		public static function getNextTuesday(): DateTime
	{
		$datetime_prochain_mardi = self::getDatetimeNow();
		$datetime_prochain_mardi->add(DateInterval::createFromDateString('next tuesday'));
		return $datetime_prochain_mardi;
	}
	
	/**
	 * @return int
	 * Retourne le nombre de jours jusqu'au prochain mardi
	 */
		public static function getDaysUntilTuesday(): int
	{
		$datetime_prochain_mardi = self::getNextTuesday();
		return $datetime_prochain_mardi->diff(self::getDatetimeNow())->days;
	}
	
	/**
	 * @param DateTime $date
	 * @return int
	 * Retourne le nombre de jours depuis $date jusqu'à aujourd'hui
	 */
	public static function getDaysUntilToday($date): int
	{
		$date_temp = self::getDatetimeNow();
		return $date->diff($date_temp)->days;
	}
	
	
	/**
	 * @param string $contexte
	 * @return array
	 *              Retourne une liste de jours jusquau prochain mardi. Le nom de ces jours change selon le contexte
	 *              Contexte "planning" : admin → planning séances : retoune tous les jours, au format NomJour NuméroJour Mois (ex : Mardi 29 avril)
	 *              Contexte "films" : front → liste films : retoune 3 jours sous la forme "Aujourd'hui, demain, jours suivants".
	 */
	public static function listeDatesJusquaMardi(string $contexte): array
	{
		$nombre_jours = self::getDaysUntilTuesday();
		$datetime_now = self::getDatetimeNow();
		$numero_jour_now = intval($datetime_now->format('w'));
		//if ($numero_jour_now === 2) $nombre_jours++;
		$dates = [];
		
		for($i = 0; $i <= $nombre_jours; $i++) {
			
			$date_temp = self::getDatetimeNow();
			$date_temp->add(new DateInterval('P' . $i . 'D'));
			$date = $date_temp->format('Y-m-d');
			$date_fr = ucfirst( IntlDateFormatter::formatObject($date_temp, "EEEE d MMMM", 'fr_FR') );
			
			if ($contexte === "planning")
			{
				$label = $date_fr;
				$dates[$date] = $label;
			}
			
			if ($contexte === "films")
			{
				if ($i == 0) $label = "Aujourd'hui";
				if ($i == 1) $label = "Demain";
				if ($i == 2) $label = $date_fr;
				if ($i == 3  && $nombre_jours > 3)
				{
					$label = "Jours suivants";
					$date = "jours_suivants";
				}
				else if ($i == 3  && $nombre_jours == 3) $label = $date_fr;
				$dates[$date] = $label;
				if ($i == 3  && $nombre_jours > 3) break;
			}
		}
		return $dates;
	}
	
}