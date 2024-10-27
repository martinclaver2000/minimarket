<?php

namespace App\Tests\Entity;

use App\Entity\Account;
use App\Entity\Ad;
use App\Entity\Category;
use App\Enum\AdStatusEnum;
use PHPUnit\Framework\TestCase;

class AdTest extends TestCase
{
    public function testGetIdInitiallyNull(): void
    {
        $ad = new Ad();
        $this->assertNull($ad->getId());
    }

    public function testSetAndGetCreatedAt(): void
    {
        $ad = new Ad();
        $createdAt = new \DateTimeImmutable();

        $ad->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $ad->getCreatedAt());
    }

    public function testSetAndGetTitle(): void
    {
        $ad = new Ad();
        $title = 'Title';

        $ad->setTitle($title);
        $this->assertSame($title, $ad->getTitle());
    }

    public function testSetAndGetDescription(): void
    {
        $ad = new Ad();
        $description = 'This is a test description.';

        $ad->setDescription($description);
        $this->assertSame($description, $ad->getDescription());
    }

    public function testSetAndGetPrice(): void
    {
        $ad = new Ad();
        $price = '150';

        $ad->setPrice($price);
        $this->assertSame($price, $ad->getPrice());
    }

    public function testSetAndGetAdStatus(): void
    {
        $ad = new Ad();
        $adStatus = AdStatusEnum::PUBLISHED;

        $ad->setAdStatus($adStatus);
        $this->assertSame($adStatus, $ad->getAdStatus());
    }

    public function testSetAndGetCategory(): void
    {
        $ad = new Ad();
        $category = new Category();

        $ad->setCategory($category);
        $this->assertSame($category, $ad->getCategory());
    }

    public function testSetAndGetAccount(): void
    {
        $ad = new Ad();
        $account = new Account();

        $ad->setAccount($account);
        $this->assertSame($account, $ad->getAccount());
    }

    public function testSetAndGetViewsCount(): void
    {
        $ad = new Ad();
        $viewsCount = 10;

        $ad->setViewsCount($viewsCount);
        $this->assertSame($viewsCount, $ad->getViewsCount());
    }

    public function testIncrementViewsCount(): void
    {
        $ad = new Ad();
        $ad->setViewsCount(5);

        $ad->incrementViewsCount();
        $this->assertSame(6, $ad->getViewsCount());
    }

    public function testSetAndGetWhatsappContactCount(): void
    {
        $ad = new Ad();
        $contactCount = 3;

        $ad->setWhatsappContactCount($contactCount);
        $this->assertSame($contactCount, $ad->getWhatsappContactCount());
    }

    public function testIncrementWhatsappContactCount(): void
    {
        $ad = new Ad();
        $ad->setWhatsappContactCount(2);

        $ad->incrementWhatsappContactCount();
        $this->assertSame(3, $ad->getWhatsappContactCount());
    }

    public function testSetAndGetMessageContactCount(): void
    {
        $ad = new Ad();
        $contactCount = 4;

        $ad->setMessageContactCount($contactCount);
        $this->assertSame($contactCount, $ad->getMessageContactCount());
    }

    public function testIncrementMessageContactCount(): void
    {
        $ad = new Ad();
        $ad->setMessageContactCount(1);

        $ad->incrementMessageContactCount();
        $this->assertSame(2, $ad->getMessageContactCount());
    }

    public function testSetAndGetAddress(): void
    {
        $ad = new Ad();
        $address = '1817 E York St,philadelphia PA 19125';

        $ad->setAddress($address);
        $this->assertSame($address, $ad->getAddress());
    }

    public function testSetAndGetSlug(): void
    {
        $ad = new Ad();
        $slug = 'slug';

        $ad->setSlug($slug);
        $this->assertSame($slug, $ad->getSlug());
    }
}
