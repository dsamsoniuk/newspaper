<?php

namespace App\Test\Controller;

use App\DataFixtures\ArticleFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ArticleControllerTest extends WebTestCase
{
    public static KernelBrowser $client;
    private ArticleRepository $articleRepo;
    private UserRepository $userRepo;
    private string $path = '/article/';

    public static function setUpBeforeClass(): void
    {
        $em = static::getContainer()->get('doctrine')->getManager();
        $passHasher = static::getContainer()->get('security.user_password_hasher');

        $fixtures = new UserFixtures($passHasher);
        $fixtures->load($em);
        $fixtiresArt = new ArticleFixtures();
        $fixtiresArt->load($em);

        self::ensureKernelShutdown();
        self::$client = self::createClient();
    }

    protected function setUp(): void
    {

        $this->articleRepo = static::getContainer()->get('doctrine')->getRepository(Article::class);

        $this->userRepo = static::getContainer()->get('doctrine')->getRepository(User::class);
        
    }

    public static function tearDownAfterClass(): void
    {
        $articleRepo = static::getContainer()->get('doctrine')->getRepository(Article::class);
        foreach ($articleRepo->findAll() as $object) {
            $articleRepo->remove($object, true);
        }

    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->articleRepo->findAll());
        $user = $this->userRepo->findOneBy(['email' => 'admin@test']);
        self::$client->loginUser($user);
        self::$client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        self::$client->submitForm('Save', [
            'article[title]' => 'Testing',
            'article[content]' => 'Testing',
            'article[date_add]' => (new DateTime('now'))->format('Y-m-d H:i')
        ]);

        self::assertResponseRedirects('/article/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->articleRepo->findAll()));
    }

    private function userProvider(){
        yield ['GET', $this->path];
        // yield ['GET', $this->path];
        // yield ['GET', $this->path.'/edit/'];
        // yield ['POST', $this->path];
    }

    /** @dataProvider userProvider */
    public function testResponseWithoutPermission(string $method, string $url){

        $this->expectException(AccessDeniedException::class);

        self::ensureKernelShutdown();
        $client = self::createClient();
        $user = $this->userRepo->findOneBy(['email' => 'user@test']);
        $client->loginUser($user);
        $client->catchExceptions(false);

        $client->request($method, $url);

        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN, 'Forbidded perm');
    }

    /** @dataProvider userProvider */
    public function testResponseWithPermission(string $method, string $url){

        $user = $this->userRepo->findOneBy(['email' => 'admin@test']);
        // $this->expectException(AccessDeniedException::class);

        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->loginUser($user);
        // $client->catchExceptions(false);

        $client->request($method, $url);

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }


    // public function testShow(): void
    // {
    //     $user = $this->userRepo->findOneBy(['email' => 'admin@test']);
    //     self::ensureKernelShutdown();
    //     $client = self::createClient();
    //     $client->loginUser($user);
    //     // $this->markTestIncomplete();
    //     // $fixture = new Article();
    //     // $fixture->setTitle('My Title');
    //     // $fixture->setContent('My Title');
    //     // $fixture->setDateAdd(new DateTime('now'));
    //     $fixture = $this->articleRepo->findOneBy([]);
    //     // $this->articleRepo->save($fixture, true);


    //     $client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Article');

    //     // Use assertions to check that the properties are properly displayed.
    // }

    // public function testEdit(): void
    // {

    //     $user = $this->userRepo->findOneBy(['email' => 'admin@test']);
    //     self::ensureKernelShutdown();
    //     $client = self::createClient();
    //     $client->loginUser($user);

    //     // $this->markTestIncomplete();
    //     $fixture = new Article();
    //     $fixture->setTitle('My Title');
    //     $fixture->setContent('My Title');
    //     $fixture->setDateAdd(new DateTime('2020-11-11 00:00'));

    //     $this->articleRepo->save($fixture, true);

    //     $client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));
    //     $newDate = (new DateTime())->format('Y-m-d H:i');
    //     $client->submitForm('Update', [
    //         'article[title]' => 'Something New',
    //         'article[content]' => 'Something New',
    //         'article[date_add]' => $newDate
    //     ]);

    //     self::assertResponseRedirects('/article/');

    //     $fixtureArt = $this->articleRepo->find($fixture->getId());

    //     self::assertSame('Something New', $fixtureArt->getTitle());
    //     // self::assertSame('Something New', $fixture[0]->getContent());
    //     // self::assertSame(new DateTime('2020-11-22 00:00'), $fixture[0]->getDateAdd());
    // }

    // public function testRemove(): void
    // {
    //     $originalNumObjectsInRepository = count($this->articleRepo->findAll());

    //     $fixture = new Article();
    //     $fixture->setTitle('My Title');
    //     $fixture->setContent('My Title');
    //     $fixture->setDateAdd(new DateTime('2020-11-11'));

    //     $this->articleRepo->save($fixture, true);

    //     self::assertSame($originalNumObjectsInRepository + 1, count($this->articleRepo->findAll()));

    //     self::$client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
    //     self::$client->submitForm('Delete');

    //     self::assertSame($originalNumObjectsInRepository, count($this->articleRepo->findAll()));
    //     self::assertResponseRedirects('/article/');
    // }
}
