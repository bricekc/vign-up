<?php

namespace App\DataFixtures;

use App\Factory\ThematiqueFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ThematiqueFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ThematiqueFactory::createSequence([['NomThematique' => 'Configuration de la parcelle'],
            ['NomThematique' => 'Données agronomiques'],
            ['NomThematique' => 'Structure de l’exploitation'],
            ['NomThematique' => 'Contexte humain'],
        ]);
    }
}
