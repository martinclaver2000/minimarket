<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<Ad>
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private Security $security)
    {
        parent::__construct($registry, Ad::class);
    }

    /**
     * @return Ad[] Returns an array of Favorite objects
     */
    public function findLastThreeAdsByUser(): array
    {
        // Récupère l'utilisateur actuellement connecté
        $user = $this->security->getUser();

        // Vérifie si l'utilisateur est authentifié
        if (!$user) {
            return []; // ou gérez cette situation en fonction de vos besoins
        }

        return $this->createQueryBuilder('ad')
            ->join('ad.account', 'account')
            ->where('account.owner = :user')
            ->setParameter('user', $user)
            ->orderBy('ad.createdAt', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Ad[] Returns an array of Ad objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ad
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
