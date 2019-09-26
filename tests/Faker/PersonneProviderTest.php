<?php

namespace App\Tests\Faker;

use App\Entity\Personne;
use PHPUnit\Framework\TestCase;

class PersonneProviderTest extends TestCase
{
    public function test()
    {
        $this->assertClassHasAttribute('date', Personne::class);
    }
}