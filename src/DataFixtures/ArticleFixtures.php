<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($j = 1; $j <= 50; $j++)
        {
            $random = mt_rand(0,4);
            $article = new Article();
            $article->setTitle(mb_strtolower($faker->sentence()))
                ->setContent($faker->paragraph())
                ->setCategory($this->getReference('categorie_'.$random));

            $manager->persist($article);
            $manager->flush();
        }
    }



    //}
    //{//$article = new Article();
    //$article->setTitle('Framework PHP : Symfony 4');
    //$article->setContent('Symfony 4, un framwork sympa à conaître !');

    //$manager->persist($article);
    //$article->setCategory($this->getReference('categorie_0'));
    //$manager->flush();
    ////}

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}