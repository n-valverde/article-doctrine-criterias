<?php

namespace App\DataFixtures;

use App\Factory\AuthorFactory;
use App\Factory\BookFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        BookFactory::createMany(100, [
            'authors' =>
                [
                    AuthorFactory::findOrCreate(['name' => 'jk-rowling'])
                ]
        ]);

        $manager->flush();
    }
}
