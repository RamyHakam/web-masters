<?php

namespace App\DataFixtures;

use App\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PageFixture extends  Fixture implements  DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $page = new Page();
        $page->setName('page name 2 from user side ')
            ->setDescription('page description')
            ->setStatus(Page::STATUS_DRAFT)
            ->setUser($this->getReference(UserFixture::MainUser));
        $manager->persist($page);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}

