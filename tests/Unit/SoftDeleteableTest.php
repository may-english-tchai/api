<?php

namespace App\Tests\Unit;

use App\Entity\Availability;
use PHPUnit\Framework\TestCase;

class SoftDeleteableTest extends TestCase
{
    public function testIsDeleted(): void
    {
        $availability = new Availability();
        $date = new \DateTime();

        $availability->setDeletedAt($date);
        static::assertTrue($availability->isDeleted());
    }
}
