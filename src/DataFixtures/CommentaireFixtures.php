<?php

namespace App\DataFixtures;

use App\Factory\CommentaireFactory;
use App\Factory\QuestionnaireFactory;
use App\Factory\ReponseFactory;
use App\Factory\ThematiqueFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Questionnaire 1 (Pour tous)
        CommentaireFactory::createSequence([
            ['commentaire' => 'Les informations renseignées sur cette parcelle semblent décrire une situation plutôt 
            défavorable à l’implantation d’une vigne semi-large. Vous pouvez avancer vers  le niveau 2 de 
            l’auto-diagnostic pour  une analyse plus fine de votre situation.',
                'questionnaire' => QuestionnaireFactory::find(1)->object(), 'notes' => [4, 5]],
            ['commentaire' => 'Les informations renseignées sur cette parcelle semblent décrire une situation plutôt favorable à 
            l’implantation d’une vigne semi-large moyennant quelques aménagements. Vous pouvez-avancer vers  le niveau 2 de 
            l’auto-diagnostic pour  une analyse plus fine de votre situation.',
                'questionnaire' => QuestionnaireFactory::find(1)->object(), 'notes' => [6]],
            ['commentaire' => 'Les informations renseignées sur cette parcelle semblent décrire une situation favorable à 
            l’implantation d’une vigne semi-large. Vous pouvez-avancer vers  le niveau 2 de l’auto-diagnostic pour connaitre les 
            possibilités d’optimisation du système.',
                'questionnaire' => QuestionnaireFactory::find(1)->object(), 'notes' => [7, 8]],
        ]);

        // Questionnaire 2 (Pour Vignerons)
        CommentaireFactory::createSequence([
            ['commentaire' => 'La structure de votre exploitation semble défavorable à un projet de transition vers les VSL.',
                'questionnaire' => QuestionnaireFactory::find(2)->object(), 'notes' => [2, 3],
                'thematique' => ThematiqueFactory::find(3)->object()],
            ['commentaire' => 'La structure de votre exploitation semble favorable à un projet de transition vers les VSL.',
                'questionnaire' => QuestionnaireFactory::find(2)->object(), 'notes' => [4, 5],
                'thematique' => ThematiqueFactory::find(3)->object()],
            ['commentaire' => 'Le contexte humain semble défavorable au projet de transition vers les VSL et 
            une concertation entre les différentes parties semble nécessaire.',
                'questionnaire' => QuestionnaireFactory::find(2)->object(), 'notes' => [3, 5],
                'thematique' => ThematiqueFactory::find(4)->object()],
            ['commentaire' => 'Le contexte humain vous permet d’envisager une  transition vers les VSL. 
            Une concertation entre les différentes parties permettrait de sécuriser le projet.',
                'questionnaire' => QuestionnaireFactory::find(2)->object(), 'notes' => [6, 7],
                'thematique' => ThematiqueFactory::find(4)->object()],
            ['commentaire' => ' Le contexte humain est favorable au projet de transition vers les VSL.',
                'questionnaire' => QuestionnaireFactory::find(2)->object(), 'notes' => [8, 9],
                'thematique' => ThematiqueFactory::find(4)->object()],
        ]);
    }
    public function getDependencies(): array
    {
        return [
            QuestionnaireFixtures::class,
            ThematiqueFixtures::class,
        ];
    }
}
