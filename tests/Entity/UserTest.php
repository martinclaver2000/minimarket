<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetIdInitiallyNull(): void
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    public function testSetAndGetEmail(): void
    {
        $user = new User();
        $email = 'martinclaver2000@gmail.com';

        $user->setEmail($email);
        $this->assertSame($email, $user->getEmail());
    }

    public function testSetAndGetRoles(): void
    {
        $user = new User();
        $roles = ['ROLE_USER'];

        $user->setRoles($roles);
        $this->assertSame($roles, $user->getRoles());
    }

    public function testSetAndGetPassword(): void
    {
        $user = new User();
        $email = 'Password1@!';

        $user->setEmail($email);
        $this->assertSame($email, $user->getEmail());
    }

    public function testSetAndGetLastName(): void
    {
        $user = new User();
        $lastName = 'Yao';

        $user->setLastName($lastName);
        $this->assertSame($lastName, $user->getLastName());
    }

    public function testSetAndGetFirstName(): void
    {
        $user = new User();
        $firstName = 'Kouandou Gnagne Martin Claver';

        $user->setFirstName($firstName);
        $this->assertSame($firstName, $user->getFirstName());
    }
}
