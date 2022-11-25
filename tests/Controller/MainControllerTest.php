<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        // $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
