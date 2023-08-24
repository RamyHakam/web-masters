<?php

namespace App\DataFixtures;

use App\Factory\AccountFactory;
use App\Factory\ArticleFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccountFixture extends  Fixture
{
    public function load(ObjectManager $manager)
    {
        $account = AccountFactory::createOne([
            'email' => 'test@test.com','roles' => ['ROLE_ADMIN']]);
        ArticleFactory::new()->createMany(10, ['account' => $account]);

        $account2 = AccountFactory::createOne([
            'email' => 'test2@test.com']);
        ArticleFactory::new()->createMany(10, ['account' => $account2]);

        AccountFactory::createMany(30);
        $manager->flush();
    }
}