<?php

namespace App\Service;

use App\Entity\Ad;
use App\Entity\User;
use App\Enum\AdStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class AdService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private Security $security,
    ) {
    }

    /**
     * Undocumented function.
     */
    public function createPersistAndFlush(Ad $ad): Ad
    {
        $user = $this->security->getUser();
        $userRepository = $this->manager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $user->getUserIdentifier()]);
        $ad
            ->setAdStatus(AdStatusEnum::CREATED)
            ->setAccount($user->getAccount())
        ;
        $this->manager->persist($ad);
        $this->manager->flush();

        return $ad;
    }

    /**
     * Undocumented function.
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
     * Undocumented function.
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
     * Undocumented function.
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
     * Undocumented function.
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
     * Undocumented function.
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
     * Undocumented function.
     */
    private function getDatetimeImmutableGMT(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', new \DateTimeZone('GMT'));
    }
}
