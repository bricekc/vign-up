<?php

namespace App\DataFixtures;

use App\Factory\ViticulteurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ViticulteurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ViticulteurFactory::createOne([
            'email' => 'shaka@example.com',
            'firstname' => 'Flavien',
            'lastname' => 'Guenault',
            'password' => 'test01',
            'num_siret' => '32564892156784',
            'verif' => true,
            'photo_profil' => 'shaka@example.com.png',
        ]);

        ViticulteurFactory::createMany(7);
    }
}
