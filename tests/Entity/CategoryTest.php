<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testGetIdInitiallyNull(): void
    {
        $category = new Category();
        $this->assertNull($category->getId());
    }

    public function testSetAndGetSlug(): void
    {
        $category = new Category();
        $slug = 'slug';

        $category->setSlug($slug);
        $this->assertSame($slug, $category->getSlug());
    }

    public function testSetAndGetParent(): void
    {
        $category = new Category();
        $parent = new Category();

        $category->setParent($parent);
        $this->assertSame($parent, $category->getParent());
    }

    public function testAddGetAndRemoveChildren(): void
    {
        $category = new Category();
        $childA = new Category();
        $childB = new Category();

        $category->addChild($childA);
        $this->assertContains($childA, $category->getChildren());

        $category->addChild($childB);
        $this->assertContains($childB, $category->getChildren());

        $this->assertCount(2, $category->getChildren());

        $category->removeChild($childA);
        $this->assertNotContains($childA, $category->getChildren());
        $this->assertCount(1, $category->getChildren());

        $category->removeChild($childB);
        $this->assertNotContains($childB, $category->getChildren());
        $this->assertCount(0, $category->getChildren());
    }
}
