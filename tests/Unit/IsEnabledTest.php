<?php

namespace App\Tests\Unit;

use App\Entity\Availability;
use PHPUnit\Framework\TestCase;

class IsEnabledTest extends TestCase
{
    public function testIsEnabled(): void
    {
        $availability = new Availability();

        $availability->setIsEnabled(true);
        static::assertTrue($availability->getIsEnabled());
    }
}
