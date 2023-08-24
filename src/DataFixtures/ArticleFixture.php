<?php

namespace App\DataFixtures;

use App\Factory\AccountFactory;
use App\Factory\ArticleFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixture extends  Fixture implements  DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        ArticleFactory::new()->createMany(30);;
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AccountFixture::class,
        ];
    }
}