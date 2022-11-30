<?php

namespace App\Test\Controller;

use App\DataFixtures\UserFixtures;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ArticleRepository $repository;
    private string $path = '/article/';

    protected function setUp(): void
    {
        $this->client = self::createClient();

        $repository = static::getContainer()->get('doctrine')->getRepository(Article::class);
        // $sec = static::getContainer()->get('debug.security.firewall');

        // $em = static::getContainer()->get('doctrine')->getManager();
        // $passHasher = static::getContainer()->get('security.user_password_hasher');
        // $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);

        // $fixtures = new UserFixtures($passHasher);
        // $fixtures->load($em);

        // /** @var UserRepository $userRepository */
        // $user = $userRepository->findOneBy(['email' => 'admin@test']);

        // $this->client->loginUser($user);


        // foreach ($this->repository->findAll() as $object) {
        //     $this->repository->remove($object, true);
        // }
    }

    public function testIndex(): void
    {

        $this->assertTrue(true);

        // $userRepo = static::getContainer()->get('doctrine')->getRepository(User::class);
        // $userRepo->save($user, true);

        // $this->client->loginUser($user, 'http_basic');
        // $this->this->client = static::createthis->Client([ ], [
        //     'PHP_AUTH_USER' => 'username',
        //     'PHP_AUTH_PW'   => 'pa$$word',
        // ]);

        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        // self::assertPageTitleContains('Article index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    // public function testNew(): void
    // {
    //     $originalNumObjectsInRepository = count($this->repository->findAll());

    //     // $this->markTestIncomplete();
    //     $this->client->request('GET', sprintf('%snew', $this->path));

    //     self::assertResponseStatusCodeSame(200);

    //     $this->client->submitForm('Save', [
    //         'article[title]' => 'Testing',
    //         'article[content]' => 'Testing',
    //         'article[date_add]' => (new DateTime('now'))->format('Y-m-d H:i')
    //     ]);

    //     self::assertResponseRedirects('/article/');

    //     self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    // }

    // public function testShow(): void
    // {
    //     // $this->markTestIncomplete();
    //     $fixture = new Article();
    //     $fixture->setTitle('My Title');
    //     $fixture->setContent('My Title');
    //     $fixture->setDateAdd(new DateTime('now'));

    //     $this->repository->save($fixture, true);

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Article');

    //     // Use assertions to check that the properties are properly displayed.
    // }

    // // public function testEdit(): void
    // // {
    // //     // $this->markTestIncomplete();
    // //     $fixture = new Article();
    // //     $fixture->setTitle('My Title');
    // //     $fixture->setContent('My Title');
    // //     $fixture->setDateAdd(new DateTime('2020-11-11 00:00'));

    // //     $this->repository->save($fixture, true);

    // //     $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

    // //     $this->client->submitForm('Update', [
    // //         'article[title]' => 'Something New',
    // //         'article[content]' => 'Something New',
    // //         'article[date_add]' => [
    // //             'date' => [
    // //                 'day' => '11',
    // //                 'month' => '11',
    // //                 'year' => '2020',
    // //             ],
    // //             'time' => [
    // //                 'minute' => '00',
    // //                 'hour' => '00',
    // //             ]
    // //         ],
    // //     ]);

    // //     // self::assertResponseRedirects('/article/');

    // //     $fixture = $this->repository->findAll();

    // //     self::assertSame('Something New', $fixture[0]->getTitle());
    // //     // self::assertSame('Something New', $fixture[0]->getContent());
    // //     // self::assertSame(new DateTime('2020-11-22 00:00'), $fixture[0]->getDateAdd());
    // // }

    // public function testRemove(): void
    // {
    //     $originalNumObjectsInRepository = count($this->repository->findAll());

    //     $fixture = new Article();
    //     $fixture->setTitle('My Title');
    //     $fixture->setContent('My Title');
    //     $fixture->setDateAdd(new DateTime('2020-11-11'));

    //     $this->repository->save($fixture, true);

    //     self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
    //     $this->client->submitForm('Delete');

    //     self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
    //     self::assertResponseRedirects('/article/');
    // }
}
