<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleImage;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $article = new Article();
        $article->setTitle('lelum');
        $article->setContent('lelum content');
        $article->setDateAdd((new DateTime()));

        $img = new ArticleImage();
        $img->setDateAdd( (new DateTime())->format('Y-m-d H:i'));
        $img->setPath('test.jpg');
        $article->addArticleImage($img);

        $manager->persist($article);

        $manager->flush();
    }
}
