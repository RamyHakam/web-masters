<?php

namespace App\DataFixtures;

use App\Factory\SymfonyGroupFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SymfonyGroupFixture extends  Fixture
{
    public function load(ObjectManager $manager)
    {

        $users = UserFactory::createMany(10);
        SymfonyGroupFactory::createOne(['members' => $users]);
        $manager->flush();
    }
}