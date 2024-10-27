<?php

namespace App\Tests\Entity;

use App\Entity\Account;
use App\Entity\Ad;
use App\Entity\Favorite;
use PHPUnit\Framework\TestCase;

class FavoriteTest extends TestCase
{
    public function testGetIdInitiallyNull(): void
    {
        $favorite = new Favorite();
        $this->assertNull($favorite->getId());
    }

    public function testSetAndGetCreatedAt(): void
    {
        $favorite = new Favorite();
        $date = new \DateTimeImmutable();

        $favorite->setCreatedAt($date);
        $this->assertSame($date, $favorite->getCreatedAt());
    }

    public function testSetAndGetAd(): void
    {
        $favorite = new Favorite();
        $ad = new Ad();

        $favorite->setAd($ad);
        $this->assertSame($ad, $favorite->getAd());
    }

    public function testSetAndGetAccount(): void
    {
        $favorite = new Favorite();
        $account = new Account();

        $favorite->setAccount($account);
        $this->assertSame($account, $favorite->getAccount());
    }
}
