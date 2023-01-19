<?php

namespace App\DataFixtures;

use App\Factory\ResultatQuestionnaireFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ResultatQuestionnaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ResultatQuestionnaireFactory::createMany(50);
    }

    public function getDependencies(): array
    {
        return [
            QuestionnaireFixtures::class,
            ReponseFixtures::class,
        ];
    }
}
