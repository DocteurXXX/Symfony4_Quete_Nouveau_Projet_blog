<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //for ($i = 1; $i <= 50; $i++) {
        foreach (self::categories as $key => $categoryName)
        {
            $category = new Category();
            $category->setName($categoryName);
            // $product = new Product();
            $manager->persist($category);
            $this->addReference('categorie_' . $key, $category);
        }

        $manager->flush();
    }

    const categories = [
        'PHP',
        'Java',
        'Javascript',
        'Ruby',
        'DevOps'
    ];
}
