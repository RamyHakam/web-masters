<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture implements  FixtureGroupInterface
{
    public const MainUser = 'main-user';
    public function load(ObjectManager $manager)
    {
        $mainUser = new User();
        $mainUser->setEmail('admin@yahoo.com')
            ->setName('testName admin')
            ->setActive(true)
            ->setPhone('109304')
            ->setPassword('123456')
            ->setDateOfBirth(new \DateTime())
            ->setPast('LEAD')
            ->setTitle('CEO');
        $manager->persist($mainUser);
        $this->addReference(self::MainUser, $mainUser);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail('tesdddlkddt@yahoo.com')
                ->setName('testName')
                ->setActive(true)
                ->setPhone('109304')
                ->setPassword('123456')
                ->setDateOfBirth(new \DateTime())
                ->setPast('LEAD')
                ->setTitle('CEO');
            $manager->persist($user);
            $manager->flush();
        }
    }

    public static function getGroups(): array
    {
        return ['main'];
    }
}