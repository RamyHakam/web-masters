<?php

namespace App\DataFixtures;

use App\Factory\PageFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PageFixture extends  Fixture implements  DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //1
      $user = UserFactory::createOne();
      PageFactory::createMany(4,['user' => $user]);
      //2

        PageFactory::createMany(10,['user' => UserFactory::new()]);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}

