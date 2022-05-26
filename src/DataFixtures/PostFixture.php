<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixture extends  Fixture implements  DependentFixtureInterface,FixtureGroupInterface
{

    public function load(ObjectManager $manager) {
        $post = new Post();
        $post->setLikes(100)
            ->setPhoto('https://google.comdkd/png')
            ->setCreatedAt(new \DateTime());
        $post->setUser($this->getReference(UserFixture::MainUser));
        $manager->persist($post);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixture::class];
    }

    public static function getGroups(): array
    {
        return ['Group1'];
    }


}
