<?php

namespace App\Tests\Type;

use App\Entity\Article;
use App\Form\ArticleType;
use DateTime;
use Symfony\Component\Form\Test\TypeTestCase;

class ArticleTypeTest extends TypeTestCase
{
    public function testFormArticle(): void
    {
        // $this->assertTrue(true);
        $article = new Article();
        $form = $this->factory->create(ArticleType::class, $article);
        $date = (new DateTime())->setDate(2020,11,11)->setTime(11,11);

        $form->submit([
            'title' => 'test',
            'content' => 'test',
            'date_add' => $date->format('Y-m-d H:i:s')
        ]);

        self::assertTrue($form->isSynchronized());

        $newArt = new Article();
        $newArt->setContent('test');
        $newArt->setTitle('test');
        $newArt->setDateAdd( $date );
        
        self::assertEquals($newArt, $article);

    }

}
