<?php

namespace App\DataFixtures;

use App\Factory\TagFactory;
use App\Factory\TypeServiceFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TypeServiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        TypeServiceFactory::createMany(30, function () {
            return [
                'tag' => TagFactory::random(),
            ];
        });
    }
    public function getDependencies(): array
    {
        return [
            TagFixture::class,
        ];
    }
}
