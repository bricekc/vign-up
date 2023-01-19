<?php

namespace App\DataFixtures;

use App\Factory\SujetFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SujetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SujetFactory::createOne(['intitule_sujet' => 'OMG 1er Sujet ????']);
        SujetFactory::createMany(6);
    }
}
