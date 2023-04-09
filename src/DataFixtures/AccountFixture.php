<?php

namespace App\DataFixtures;

use App\Factory\AccountFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccountFixture extends  Fixture
{
    public function load(ObjectManager $manager)
    {
        AccountFactory::createOne([
            'email' => 'test@test.com']);
        AccountFactory::createMany(30);
        $manager->flush();
    }
}