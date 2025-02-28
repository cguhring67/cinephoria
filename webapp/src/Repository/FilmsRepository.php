<?php

namespace App\Repository;

use App\Entity\Films;
use App\Entity\Seances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Films>
 */
class FilmsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Films::class);
    }

	/**
	 * @return Seances[] Returns an array of Seances objects
	 */
	public function findFilmsByFiltres($date_search, $genre_search="", $technologie_search="" ): array
	{

		$date_recherche = new \DateTime($date_search);
		$date_now_format = $date_recherche->format('Y-m-d H:i:s');

		$date_matin = $date_recherche->setTime(8, 0, 0);
		$date_matin_format = $date_matin->format('Y-m-d H:i:s');
		$date_soir = $date_recherche->setTime(23, 59, 59);
		$date_soir_format = $date_soir->format('Y-m-d H:i:s');

		if ($date_search == "now") $date_matin_format = $date_now_format;

//		$conn = $this->getEntityManager()->getConnection();
//
//		$sql = '
//            SELECT f.* FROM films f, seances s
//            WHERE f.id = s.film_id_id AND s.date_debut > :date_matin AND s.date_debut < :date_soir
//            GROUP BY f.id
//            ORDER BY f.date_ajout DESC
//            ';
//
//		$resultSet = $conn->executeQuery($sql, [
//			'date_matin' => $date_matin_format,
//			'date_soir' => $date_soir_format,
//			'genre' => 'drame',
//		]);

		// returns an array of arrays (i.e. a raw data set)
		//return $resultSet->fetchAllAssociative();


		$qb = $this->createQueryBuilder('f');

		$qb->select( 'f' )
//			->from( 'AppBundle:Films', 'f' )
			->innerJoin( 'f.seances', 's' ) // fameuse jointure
			->andWhere($qb->expr()->between('s.date_debut', ':date_matin', ':date_soir'));

		if ($genre_search != "")
		{
			$qb->andWhere($qb->expr()->like('f.genre', ':genre'));
		}

		$qb->groupBy('f.id')
			->setParameter('date_matin', $date_matin_format)
			->setParameter('date_soir', $date_soir_format);

		if ($genre_search != "")
		{
			$qb->setParameter('genre', '%' . $genre_search . '%');
		}

		$query = $qb->getQuery();
		return $query->execute();


	}



    //    /**
    //     * @return Films[] Returns an array of Films objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Films
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
