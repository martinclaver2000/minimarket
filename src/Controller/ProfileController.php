<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Favorite;
use App\Form\AdType;
use App\Form\UserType;
use App\Repository\AdRepository;
use App\Repository\FavoriteRepository;
use App\Service\AdService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/profile', name: 'app_profile_')]
#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    // Ad controllers
    #[Route('/ads', name: 'ad_index', methods: ['GET'])]
    public function indexAd(AdRepository $adRepository): Response
    {
        return $this->render('profile/ad/index.html.twig', [
            'ads' => $adRepository->findAllByUser(),
        ]);
    }

    #[Route('/ads/new', name: 'ad_new', methods: ['GET', 'POST'])]
    public function newAd(Request $request, AdService $adService): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adService->createPersistAndFlush($ad);

            return $this->redirectToRoute('app_profile_ad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/ad/new.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    #[Route('/ads/edit/{slug}', name: 'ad_edit', methods: ['GET', 'POST'])]
    public function editAd(
        Request $request,
        #[MapEntity(mapping: ['slug' => 'slug'])] Ad $ad,
        EntityManagerInterface $entityManager,
    ): Response {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_ad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    #[Route('/ads/{slug}', name: 'ad_delete', methods: ['POST'])]
    public function deleteAd(
        Request $request,
        #[MapEntity(mapping: ['slug' => 'slug'])] Ad $ad,
        EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ad->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profile_ad_index', [], Response::HTTP_SEE_OTHER);
    }

    // Favorite controllers
    #[Route('/favorites', name: 'favorite_index', methods: ['GET'])]
    public function indexFavorite(FavoriteRepository $favoriteRepository): Response
    {
        return $this->render('profile/favorite/index.html.twig', [
            'favorites' => $favoriteRepository->findAllByUser(),
        ]);
    }

    #[Route('/favorites/{slug}', name: 'favorite_delete', methods: ['POST'])]
    public function deleteFavorite(
        Request $request,
        #[MapEntity(mapping: ['slug' => 'slug'])] Favorite $favorite,
        EntityManagerInterface $entityManager
        ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favorite->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($favorite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_favorite_index', [], Response::HTTP_SEE_OTHER);
    }

    // Setting controller

    #[Route('/settings', name: 'setting_index', methods: ['GET'])]
    public function indexSetting(): Response
    {
        return $this->render('profile/setting/index.html.twig');
    }

    #[Route('/setting/edit', name: 'setting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_setting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/setting/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/setting', name: 'setting_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$user->getUserIdentifier(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logout', [], Response::HTTP_SEE_OTHER);
    }
}
