<?php

namespace App\DataFixtures;

use App\Factory\PostFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        PostFactory::createMany(50);
    }

    public function getDependencies(): array
    {
        return [
            AdminFixtures::class,
            ViticulteurFixtures::class,
            FournisseurFixtures::class,
            SujetFixtures::class,
        ];
    }
}
