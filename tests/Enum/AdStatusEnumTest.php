<?php

namespace App\Tests\Enum;

use App\Enum\AdStatusEnum;
use PHPUnit\Framework\TestCase;

class AdStatusEnumTest extends TestCase
{
    public function testEnumValues(): void
    {
        $this->assertSame('created', AdStatusEnum::CREATED->value);
        $this->assertSame('published', AdStatusEnum::PUBLISHED->value);
        $this->assertSame('sold', AdStatusEnum::SOLD->value);
        $this->assertSame('expired', AdStatusEnum::EXPIRED->value);
        $this->assertSame('denied', AdStatusEnum::DENIED->value);
        $this->assertSame('deleted', AdStatusEnum::DELETED->value);
    }

    public function testEnumCases(): void
    {
        $enumCases = AdStatusEnum::cases();
        $this->assertCount(6, $enumCases);
    }
}
