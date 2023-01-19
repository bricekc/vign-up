<?php

namespace App\DataFixtures;

use App\Factory\FournisseurFactory;
use App\Factory\TypeMaterielFactory;
use App\Factory\TypeServiceFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FournisseurFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        FournisseurFactory::createOne([
            'email' => 'brick@example.com',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test02',
            'ville' => 'Noyers',
            'cp' => '51100',
            'adresse' => '69 rue du FOUR',
            'photo_profil' => 'brick@example.com.png',
        ]);
        for ($i = 0; $i < 10; ++$i) {
            FournisseurFactory::createMany(1, ['type_materiel_propose' => [TypeMaterielFactory::random()],
                'type_service_propose' => [TypeServiceFactory::random()], ]);
        }
    }

    public function getDependencies()
    {
        return [
            TypeMaterielFixtures::class,
            TypeServiceFixtures::class,
        ];
    }
}
