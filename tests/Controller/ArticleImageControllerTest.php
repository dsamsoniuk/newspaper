<?php

namespace App\Test\Controller;

use App\Entity\Article;
use App\Entity\ArticleImage;
use App\Repository\ArticleImageRepository;
use App\Repository\ArticleRepository;
use DateTime;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleImageControllerTest extends WebTestCase
{
    public static KernelBrowser $client;
    private ArticleImageRepository $repository;
    private ArticleRepository $articleRepository;

    private string $path = '/uploads/image/';

    public static function setUpBeforeClass(): void
    {
        self::ensureKernelShutdown();
        self::$client = self::createClient();
    }

    protected function setUp(): void
    {
        $this->repository = self::getContainer()->get('doctrine')->getRepository(ArticleImage::class);
        $this->articleRepository = self::getContainer()->get('doctrine')->getRepository(Article::class);

    }
    protected function tearDown(): void
    {
        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
        foreach ($this->articleRepository->findAll() as $art) {
            $this->articleRepository->remove($art, true);
        }
    }

    public function testIndex(): void
    {
        self::assertTrue(true);

        $crawler = self::$client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        // self::assertPageTitleContains('ArticleImage index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Article();
        $fixture->setDateAdd((new DateTime('now')));
        $fixture->setTitle('test');
        $fixture->setContent('test');
        $this->articleRepository->save($fixture, true);

        // $this->markTestIncomplete();
        self::$client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        self::$client->submitForm('Save', [
            'article_image[path]' => 'Testing',
            'article_image[date_add]' => '2020-11-11',
            'article_image[article]' => $fixture->getId(),
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {

        $article = new Article();
        $article->setDateAdd((new DateTime('now')));
        $article->setTitle('test');
        $article->setContent('test');
        $this->articleRepository->save($article, true);

        $fixture = new ArticleImage();
        $fixture->setPath('My Title');
        $fixture->setDateAdd('2020-11-11');
        $fixture->setArticle($article);

        $this->repository->save($fixture, true);

        self::$client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        // self::assertPageTitleContains('ArticleImage');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {

        $article = new Article();
        $article->setDateAdd((new DateTime('now')));
        $article->setTitle('test');
        $article->setContent('test');
        $this->articleRepository->save($article, true);

        $fixture = new ArticleImage();
        $fixture->setPath('path/test');
        $fixture->setDateAdd('2021-11-11');
        $fixture->setArticle($article);

        $this->repository->save($fixture, true);

        self::$client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        self::$client->submitForm('Update', [
            'article_image[path]' => 'new/path',
            'article_image[date_add]' => '2022-11-11',
            'article_image[article]' => $article->getId(),
        ]);

        self::assertResponseRedirects($this->path);

        $fixture = $this->repository->findAll();

        self::assertSame('new/path', $fixture[0]->getPath());
        self::assertSame('2022-11-11', $fixture[0]->getDateAdd());
    }

    public function testRemove(): void
    {

        $article = new Article();
        $article->setDateAdd((new DateTime('now')));
        $article->setTitle('test');
        $article->setContent('test');
        $this->articleRepository->save($article, true);

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new ArticleImage();
        $fixture->setPath('test/path');
        $fixture->setDateAdd((new DateTime('now'))->format('Y-m-d'));
        $fixture->setArticle($article);

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        self::$client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()), [], [], [
            'HTTP_REFERER' => $this->path,
        ]);
        self::$client->submitForm('Delete');
        // self::assertResponseRedirects($this->path.$fixture->getId());

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));

    }
}
