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
	public function findFilmsByFiltres($date_search1, $date_search2, $genre_search="", $technologie_search="", $cinema_search="" ): array
	{

		$date_recherche1 = new \DateTime($date_search1);
		$date_recherche2 = new \DateTime($date_search2);
		$date_now_format = $date_recherche1->format('Y-m-d H:i:s');

		$date_debut = $date_recherche1->setTime(8, 0, 0);
		$date_debut_format = $date_debut->format('Y-m-d H:i:s');
		$date_fin = $date_recherche2->setTime(23, 59, 59);
		$date_fin_format = $date_fin->format('Y-m-d H:i:s');

		if ($date_search1 == "now") $date_debut_format = $date_now_format;


		$qb = $this->createQueryBuilder('f');

		$qb->select( 'f' )
			->innerJoin( 'f.seances', 's' ) // fameuse jointure
			->andWhere($qb->expr()->between('s.date_debut', ':date_debut', ':date_fin'));

		if ($genre_search != "")
		{
			$qb->andWhere($qb->expr()->like('f.genre', ':genre'));
		}

		if ($cinema_search != "")
		{
			$qb->andWhere('s.cinema_id = :cinema');
		}

		$qb->groupBy('f.id')
			->setParameter('date_debut', $date_debut_format)
			->setParameter('date_fin', $date_fin_format);

		if ($genre_search != "")
		{
			$qb->setParameter('genre', '%' . $genre_search . '%');
		}
		if ($cinema_search != "")
		{
			$qb->setParameter('cinema', $cinema_search);
		}
		$qb->orderBy('f.date_ajout', 'DESC');


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
