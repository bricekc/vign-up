<?php

namespace App\Tests\Controller\Questionnaire;

use App\Factory\FournisseurFactory;
use App\Factory\QuestionFactory;
use App\Factory\QuestionnaireFactory;
use App\Factory\ReponseFactory;
use App\Factory\ThematiqueFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    /*
     * test qui vérifie qu'un questionnaire pour tout public s'affiche bien
     */
    public function questionnaireNotConnected(ControllerTester $I)
    {
        $thematiques = ThematiqueFactory::createSequence([['NomThematique' => 'thématique1'],
            ['NomThematique' => 'thématique2'],
        ]);
        QuestionnaireFactory::createOne(['intitule_questionnaire' => 'Questionnaire pour tous', 'public' => true, 'thematiques' => $thematiques]);
        QuestionFactory::createOne(['intitule_question' => 'Question 1?',
                                    'thematique' => $thematiques[0],
                                    'questionnaire' => QuestionnaireFactory::find(1)->object()]);
        $I->amOnPage('/questionnaire/1');
        $I->seeNumberOfElements('h2', 2);
        $I->see('Question 1?', 'div');
        $I->seeNumberOfElements('#questionnaire_question_1', 1);
        $I->see('Envoyer', 'button');
    }

    /*
     * test qui vérifie qu'un questionnaire pour viticulteur a bien la restriction
     * que si l'utilisateur n'est pas un viticulteur alors il doit se connecter
     * en tant que viticulteur
     */
    public function RestrictionConnexionQuestion(ControllerTester $I)
    {
        $fournissuer = FournisseurFactory::createOne();
        $thematiques = ThematiqueFactory::createSequence([['NomThematique' => 'thématique1'],
            ['NomThematique' => 'thématique2'],
        ]);
        QuestionnaireFactory::createOne(['intitule_questionnaire' => 'Questionnaire pour tous', 'public' => false, 'thematiques' => $thematiques]);
        $I->amLoggedInAs($fournissuer->object());
        $I->amOnPage('/questionnaire/1');
        $I->seeCurrentUrlEquals('/login');
    }

    /*
     * test qui vérifie qu'un questionnaire pour viticulteur s'affiche bien
     * pour un viticulteur
     */
    public function questionnaireConnected(ControllerTester $I)
    {
        $thematiques = ThematiqueFactory::createSequence([['NomThematique' => 'thématique1'],
            ['NomThematique' => 'thématique2'],
        ]);
        QuestionnaireFactory::createOne(['intitule_questionnaire' => 'Questionnaire pour tous', 'public' => true, 'thematiques' => $thematiques]);
        QuestionFactory::createOne(['intitule_question' => 'Question 1?',
            'thematique' => $thematiques[0],
            'questionnaire' => QuestionnaireFactory::find(1)->object()]);
        ReponseFactory::createOne(['reponse' => 'reponse1',
            'question' => QuestionFactory::find(1)->object()]);
        $viticulteur = ViticulteurFactory::createOne();
        $I->amLoggedInAs($viticulteur->object());
        $I->amOnPage('/questionnaire/1');
        $I->seeNumberOfElements('h2', 2);
        $I->see('Question 1?', 'div');
        $I->seeNumberOfElements('#questionnaire_question_1', 1);
        $I->see('reponse1', 'div');
        $I->see('Envoyer', 'button');
    }
}
