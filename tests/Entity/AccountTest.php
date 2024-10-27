<?php

namespace App\Tests\Entity;

use App\Entity\Account;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testGetIdInitiallyNull(): void
    {
        $account = new Account();
        $this->assertNull($account->getId());
    }

    public function testSetAndGetCreatedAt(): void
    {
        $account = new Account();
        $date = new \DateTimeImmutable();

        $account->setCreatedAt($date);
        $this->assertSame($date, $account->getCreatedAt());
    }

    public function testSetAndGetOwner(): void
    {
        $account = new Account();
        $user = new User();

        $account->setOwner($user);
        $this->assertSame($user, $account->getOwner());
    }
}
