<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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
