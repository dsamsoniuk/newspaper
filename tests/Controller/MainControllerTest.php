<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public static KernelBrowser $client;

    public static function setUpBeforeClass(): void
    {
        self::ensureKernelShutdown();
        self::$client = self::createClient();
    }
    public function testIndex(): void
    {
        $crawler = self::$client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        // $this->assertResponseStatusCodeSame(200);
        // $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
