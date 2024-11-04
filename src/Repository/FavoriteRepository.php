<?php

namespace App\Repository;

use App\Entity\Favorite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<Favorite>
 */
class FavoriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private Security $security)
    {
        parent::__construct($registry, Favorite::class);
    }

    /**
     * @return Favorite[] Returns an array of Favorite objects
     */
    public function findLastThreeFavoritesByUser(): array
    {
        // Récupère l'utilisateur actuellement connecté
        $user = $this->security->getUser();

        // Vérifie si l'utilisateur est authentifié
        if (!$user) {
            return []; // ou gérez cette situation en fonction de vos besoins
        }

        return $this->createQueryBuilder('f')
            ->where('f.owner = :owner')
            ->setParameter('owner', $user)
            ->orderBy('f.createdAt', 'DESC') // Assurez-vous d'avoir un champ `createdAt` dans `Favorite`
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Favorite[] Returns an array of Favorite objects
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

    //    public function findOneBySomeField($value): ?Favorite
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
