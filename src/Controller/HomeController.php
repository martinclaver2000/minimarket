<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(FavoriteRepository $favoriteRepository, AdRepository $adRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'ads' => $adRepository->findAll(),
            'myAds' => $adRepository->findLastThreeAdsByUser(),
            'favorites' => $favoriteRepository->findLastThreeFavoritesByUser(),
        ]);
    }

    #[Route('/ads/{slug}', name: 'app_ad', methods: ['GET'])]
    public function show(Ad $ad, EntityManagerInterface $entityManager): Response
    {
        $ad->incrementViewsCount();
        $entityManager->persist($ad);
        $entityManager->flush();

        $similarAds = $entityManager->getRepository(Ad::class)->findBy([
            'category' => $ad->getCategory(),
        ], null, 6);

        return $this->render('home/show.html.twig', [
            'ad' => $ad,
            'similarAds' => $similarAds,
        ]);
    }
}
