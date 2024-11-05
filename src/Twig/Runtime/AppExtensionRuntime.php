<?php

namespace App\Twig\Runtime;

use App\Entity\User;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
    }

    public function formatNameWithInitials(User $user): string
    {
        $initials = '';
        $parts = explode(' ', $user->getLastName());

        foreach ($parts as $name) {
            $initials .= strtoupper($name[0]).'.';
        }

        return strtoupper($user->getLastName()).' '.$initials;
    }
}
