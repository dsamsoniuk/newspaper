<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use DateTime;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testEntity(): void
    {
        $date = (new DateTime())->setDate(2000,11,11)->setTime(11,11);
        $article = new Article();

        $article->setTitle('test');
        $article->setContent('test');
        $article->setDateAdd($date);


        $this->assertSame('test', $article->getTitle());
        $this->assertSame('test', $article->getContent());
        $this->assertSame($date , $article->getDateAdd());
    }
}
