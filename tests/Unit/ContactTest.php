<?php

namespace App\Tests\Unit;

use App\Entity\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function testSetPhone(): void
    {
        $contact = new Contact();
        $contact->setPhone('0612345678');

        static::assertEquals('0612345678', $contact->getPhone());
    }
}
