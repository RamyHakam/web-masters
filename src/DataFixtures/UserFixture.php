<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\PostFactory;
use App\Factory\SymfonyGroupFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture implements  FixtureGroupInterface
{
    public const MainUser = 'main-user';
    public function load(ObjectManager $manager)
    {
        SymfonyGroupFactory::createMany(10);
         UserFactory::createMany(30,['posts' => PostFactory::new()->many(10),'groups' => SymfonyGroupFactory::randomRange(1,5)]);
         $manager->flush();

    }
    public static function getGroups(): array
    {
        return ['main'];
    }
}