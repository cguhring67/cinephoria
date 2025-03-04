<?php

namespace App\Repository;

use App\Entity\Seances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seances>
 */
class SeancesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seances::class);
    }


	/**
	 * @return Seances[] Returns an array of Seances objects
	 */
	public function findByDateSeance($date_search): array
	{

		$date_recherche = new \DateTime($date_search);
		$date_now_format = $date_recherche->format('Y-m-d H:i:s');

		$date_matin = $date_recherche->setTime(8, 0, 0);
		$date_matin_format = $date_matin->format('Y-m-d H:i:s');
		$date_soir = $date_recherche->setTime(23, 59, 59);
		$date_soir_format = $date_soir->format('Y-m-d H:i:s');


		$qb = $this->createQueryBuilder('s');

		$qb->andWhere($qb->expr()->andX(
				$qb->expr()->gte('s.date_debut', ':date_matin'),
				$qb->expr()->lte('s.date_debut', ':date_soir')
			))
			->setParameter('date_matin', $date_matin_format)
			->setParameter('date_soir', $date_soir_format);

		$query = $qb->getQuery();
		return $query->execute();

	}


	/**
	 * @return Seances[] Returns an array of Seances objects
	 */
	public function findByDateAndSalle($salle, $date_search = "now"): array
	{
		$date_recherche = new \DateTime($date_search);
		$date_matin = $date_recherche->setTime(8, 0, 0);
		$date_matin_format = $date_matin->format('Y-m-d H:i:s');
		$date_soir = $date_recherche->setTime(23, 59, 59);
		$date_soir_format = $date_soir->format('Y-m-d H:i:s');

		$qb = $this->createQueryBuilder('s');

		$qb->andWhere('s.salle_id = :salle')
			->andWhere($qb->expr()->between('s.date_debut', ':date_matin', ':date_soir'))
			->setParameter('date_matin', $date_matin_format)
			->setParameter('date_soir', $date_soir_format)
			->setParameter('salle', $salle);

		$query = $qb->getQuery();
		return $query->execute();
	}



//	/**
//      * @return Seances[] Returns an array of Seances objects
//      */
//     public function findByDateSeance($date_search): array
//     {
//
//         return $this->createQueryBuilder('s')
//             ->andWhere('s.exampleField = :val')
//             ->setParameter('val', $value)
//             ->orderBy('s.id', 'ASC')
//             ->setMaxResults(10)
//             ->getQuery()
//             ->getResult()
//         ;
//     }

//	public function findAllGreaterThanPrice(int $price, bool $includeUnavailableProducts = false): array
//	{
//		// automatically knows to select Products
//		// the "p" is an alias you'll use in the rest of the query
//		$qb = $this->createQueryBuilder('p')
//			->where('p.price > :price')
//			->setParameter('price', $price)
//			->orderBy('p.price', 'ASC');
//
//		if (!$includeUnavailableProducts) {
//			$qb->andWhere('p.available = TRUE');
//		}
//
//		$query = $qb->getQuery();
//
//		return $query->execute();
//
//		// to get just one result:
//		// $product = $query->setMaxResults(1)->getOneOrNullResult();
//	}
//

    //    public function findOneBySomeField($value): ?Seances
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
