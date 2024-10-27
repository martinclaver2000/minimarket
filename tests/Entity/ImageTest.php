<?php

namespace App\Tests\Entity;

use App\Entity\Ad;
use App\Entity\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testGetIdInitiallyNull(): void
    {
        $Image = new Image();
        $this->assertNull($Image->getId());
    }

    public function testSetAndGetFilName(): void
    {
        $image = new Image();
        $fileName = 'image.png';

        $image->setFileName($fileName);
        $this->assertSame($fileName, $image->getFileName());
    }

    public function testSetAndGetAd(): void
    {
        $image = new Image();
        $ad = new Ad();

        $image->setAd($ad);
        $this->assertSame($ad, $image->getAd());
    }
}
