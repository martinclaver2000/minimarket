<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Favorite;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    #[Route('/favorite/toggle/{slug}', name: 'app_favorite_toggle')]
    public function toggleFavorite(Ad $ad, EntityManagerInterface $em): JsonResponse
    {
        $isFavorite = false;

        $connectedUser = $this->getUser();
        $email = $connectedUser->getUserIdentifier();
        $realUser = $em->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$realUser) {
            return $this->json(['isFavorite' => $isFavorite]);
        }

        $favorite = $em->getRepository(Favorite::class)->findOneBy([
            'ad' => $ad,
            'owner' => $realUser,
        ]);

        if (!$favorite) {
            $favorite = new Favorite();
            $favorite
                ->setAd($ad)
                ->setOwner($realUser)
            ;
            $em->persist($favorite);
            $em->flush();
            $isFavorite = true;

            return $this->json(['isFavorite' => $isFavorite]);
        }

        $em->remove($favorite);
        $em->flush();

        return $this->json(['isFavorite' => $isFavorite]);
    }
}
