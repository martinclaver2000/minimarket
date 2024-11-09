<?php

namespace App\Service;

use App\Entity\Ad;
use App\Entity\User;
use DateTimeImmutable;
use App\Enum\AdStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdService
{
    public function __construct(
        private SluggerInterface $slugger,
        private EntityManagerInterface $manager,
        private Security $security
    ) {
    }

    /**
     * Undocumented function
     *
     * @param Ad $ad
     * @return Ad
     */
    public function createPersistAndFlush(Ad $ad): Ad
    {
        $user = $this->security->getUser();
        $userRepository = $this->manager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $user->getUserIdentifier()]);
        $ad
            ->setAdStatus(AdStatusEnum::CREATED)
            ->setCreatedAt($this->getDatetimeImmutableGMT())
            ->setSlug($this->generateSlug($ad))
            ->setAccount($user->getAccount())
        ;
        $this->manager->persist($ad);
        $this->manager->flush();
        return $ad;
    }

    /**
     * Undocumented function
     *
     * @param Ad $ad
     * @return Ad
     */
    public function publishAndFlush(Ad $ad): Ad
    {
        $ad
            ->setAdStatus(AdStatusEnum::PUBLISHED)
            ->setPublishedAt($this->getDatetimeImmutableGMT())
        ;
        $this->manager->flush();

        return $ad;
    }

    /**
     * Undocumented function
     *
     * @param Ad $ad
     * @return Ad
     */
    public function soldAndFlush(Ad $ad): Ad
    {
        $ad
            ->setAdStatus(AdStatusEnum::SOLD)
            ->setSoldAt($this->getDatetimeImmutableGMT())
        ;
        $this->manager->flush();

        return $ad;
    }

    /**
     * Undocumented function
     *
     * @param Ad $ad
     * @return Ad
     */
    public function expireAndFlush(Ad $ad): Ad
    {
        $ad
            ->setAdStatus(AdStatusEnum::EXPIRED)
            ->setExpiredAt($this->getDatetimeImmutableGMT())
        ;
        $this->manager->flush();

        return $ad;
    }

    /**
     * Undocumented function
     *
     * @param Ad $ad
     * @return Ad
     */
    public function denyAndFlush(Ad $ad): Ad
    {
        $ad
            ->setAdStatus(AdStatusEnum::DENIED)
            ->setDeniedAt($this->getDatetimeImmutableGMT())
        ;
        $this->manager->flush();

        return $ad;
    }

    /**
     * Undocumented function
     *
     * @param Ad $ad
     * @return Ad
     */
    public function deleteAndFlush(Ad $ad): Ad
    {
        $ad
            ->setAdStatus(AdStatusEnum::DELETED)
            ->setDeletedAt($this->getDatetimeImmutableGMT())
        ;
        $this->manager->flush();

        return $ad;
    }

    /**
     * Undocumented function
     *
     * @param Ad $ad
     * @return string
     */
    private function generateSlug(Ad $ad): string
    {
        $slug = strtolower($ad->getCategory()->getName().' '.$ad->getTitle().' '.uniqid());

        return $this->slugger->slug($slug, '_');
    }

    /**
     * Undocumented function
     *
     * @return DateTimeImmutable
     */
    private function getDatetimeImmutableGMT(): DateTimeImmutable
    {
        return new \DateTimeImmutable('now', new \DateTimeZone('GMT'));
    }
}
