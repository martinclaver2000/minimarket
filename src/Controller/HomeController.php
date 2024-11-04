<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use App\Repository\FavoriteRepository;
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

    #[Route('/{slug}', name: 'app_ad', methods: ['GET'])]
    public function show(Ad $ad, FavoriteRepository $favoriteRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'ad' => $ad,
            'favorites' => $favoriteRepository->findLastThreeFavoritesByUser(),
        ]);
    }
}
