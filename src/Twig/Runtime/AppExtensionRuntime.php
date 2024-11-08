<?php

namespace App\Twig\Runtime;

use App\Entity\Ad;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(private Security $security, private EntityManagerInterface $em)
    {
    }

    public function formatNameWithInitials(User $user): string
    {
        $initials = '';
        $parts = explode(' ', $user->getFirstName());

        foreach ($parts as $name) {
            $initials .= strtoupper($name[0]).'.';
        }

        return strtoupper($user->getLastName()).' '.$initials;
    }

    /**
     * Undocumented function.
     */
    public function hasFavorite(Ad $ad): bool
    {
        $connectedUser = $this->security->getUser();
        if (!$connectedUser) {
            return false;
        }
        $userRepository = $this->em->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $connectedUser->getUserIdentifier()]);
        foreach ($user->getFavorites() as $favorite) {
            if ($favorite->getAd() === $ad) {
                return true;
            }
        }

        return false;
    }
}
