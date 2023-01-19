<?php

namespace App\DataFixtures;

use App\Factory\TagFactory;
use App\Factory\TypeMaterielFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TypeMaterielFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        TypeMaterielFactory::createMany(30, function () {
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
