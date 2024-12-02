<?php

namespace App\Controller;

use App\Entity\Ad;
use Pagerfanta\Pagerfanta;
use App\Repository\AdRepository;
use App\Service\CategoryService;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(
        Request $request,
        FavoriteRepository $favoriteRepository,
        AdRepository $adRepository
        ): Response
    {
        $queryBuilder = $adRepository->findAllByQueryBuilder();
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->getInt('page', 1),
            16
        );
        return $this->render('home/index.html.twig', [
            'pager' => $pagerfanta,
            'myAds' => $adRepository->findLastThreeAdsByUser(),
            'favorites' => $favoriteRepository->findLastThreeFavoritesByUser(),
        ]);
    }

    #[Route('/ads/{slug}', name: 'app_ad', methods: ['GET', 'POST'])]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ad $ad,
        EntityManagerInterface $entityManager,
        CategoryService $categoryService,
    ): Response {
        $ad->incrementViewsCount();
        $entityManager->persist($ad);
        $entityManager->flush();

        $similarAds = $entityManager->getRepository(Ad::class)->findBy([
            'category' => $ad->getCategory(),
        ], null, 6);

        return $this->render('home/show.html.twig', [
            'ad' => $ad,
            'similarAds' => $similarAds,
            'categoriesHierachy' => $categoryService->getCategoryHierarchy($ad->getCategory()),
        ]);
    }

    #[Route('/whatsapp_contact_count/{slug}', name: 'app_whatsapp_contact_count', methods: ['POST'])]
    public function whatsappContactCount(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ad $ad,
        EntityManagerInterface $em,
    ): Response {
        $ad->incrementWhatsappContactCount();
        $em->flush();

        return $this->json(['message' => 'done!']);
    }

    #[Route('/message_contact_count/{slug}', name: 'app_message_contact_count', methods: ['POST'])]
    public function messageContactCount(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ad $ad,
        EntityManagerInterface $em,
    ): Response {
        $ad->incrementMessageContactCount();
        $em->flush();

        return $this->json(['message' => 'done!']);
    }

    #[Route('/phone_number_contact_count/{slug}', name: 'app_phone_number_contact_count', methods: ['POST'])]
    public function phoneNumberContactCount(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ad $ad,
        EntityManagerInterface $em,
    ): Response {
        $ad->incrementPhoneNumberContactCount();
        $em->flush();

        return $this->json(['message' => 'done!']);
    }
}
