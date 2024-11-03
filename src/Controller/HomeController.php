<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Favorite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods:['GET'])]
    public function index(EntityManagerInterface $manager): Response
    {
        return $this->render('home/index.html.twig', [
            'ads' => $manager->getRepository(Ad::class)->findAll(),
            'favorites' => $manager->getRepository(Favorite::class)->findLastThreeFavoritesByUser()
        ]);
    }

    #[Route('/{slug}', name: 'app_ad', methods:['GET'])]
    public function show(EntityManagerInterface $manager): Response
    {
        return $this->render('home/index.html.twig', [
            'ads' => $manager->getRepository(Ad::class)->findAll(),
            'favorites' => $manager->getRepository(Favorite::class)->findLastThreeFavoritesByUser()
        ]);
    }
}
