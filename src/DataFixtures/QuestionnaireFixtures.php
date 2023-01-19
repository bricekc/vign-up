<?php

namespace App\DataFixtures;

use App\Factory\QuestionnaireFactory;
use App\Factory\ThematiqueFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionnaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $thematiques = new ArrayCollection();
        $thematiques->add(ThematiqueFactory::find(1)->object());
        $thematiques->add(ThematiqueFactory::find(2)->object());
        $thematiques->add(ThematiqueFactory::find(3)->object());
        $thematiques->add(ThematiqueFactory::find(4)->object());

        QuestionnaireFactory::createOne(['intitule_questionnaire' => 'Questionnaire pour tous', 'public' => true, 'thematiques' => new ArrayCollection()]);
        QuestionnaireFactory::createOne(['intitule_questionnaire' => 'Questionnaire pour Viticulteurs',
            'public' => false, 'thematiques' => $thematiques]);
    }

    public function getDependencies(): array
    {
        return [
            ThematiqueFixtures::class,
        ];
    }
}
