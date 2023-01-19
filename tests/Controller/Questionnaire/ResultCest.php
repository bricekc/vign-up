<?php

namespace App\Tests\Controller\Questionnaire;

use App\Factory\CommentaireFactory;
use App\Factory\QuestionFactory;
use App\Factory\QuestionnaireFactory;
use App\Factory\ReponseFactory;
use App\Factory\ResultatQuestionnaireFactory;
use App\Factory\ThematiqueFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;
use Doctrine\Common\Collections\ArrayCollection;

class ResultCest
{
    /*
     * fonction qui test l'affichage des résultats d'un questionnaire
     */
    public function resultat(ControllerTester $I)
    {
        $viticulteur = ViticulteurFactory::createOne();
        $thematiques = ThematiqueFactory::createSequence([['NomThematique' => 'thématique1'],
            ['NomThematique' => 'thématique2'], ]);
        $questionnaire = QuestionnaireFactory::createOne(['intitule_questionnaire' => 'Questionnaire pour tous', 'public' => false, 'thematiques' => $thematiques]);
        $question = QuestionFactory::createOne(['intitule_question' => 'Question 1?',
            'thematique' => $thematiques[0],
            'questionnaire' => $questionnaire->object()]);
        $reponse = new ArrayCollection();
        $reponse->add(ReponseFactory::createOne(['reponse' => 'reponse1',
            'question' => QuestionFactory::find(1)->object(),
            'note' => 1, ])->object());
        ResultatQuestionnaireFactory::createOne(['viticulteur' => $viticulteur->object(),
            'questionnaire' => $questionnaire->object(),
            'reponses' => $reponse, 'note' => 10, ]);
        $I->amLoggedInAs($viticulteur->object());
        $I->amOnPage('/questionnaire/resultat/1');
        $I->seeResponseCodeIs(200);
        $I->canSeeInCurrentUrl('/questionnaire/resultat/1');
        $I->see('Questionnaire pour tous');
        $I->see('Question 1?', 'p');
        $I->see('Score Globale : 10', '.Score');
        $I->see('Score : 1', '.Score');
        $I->see('Thématique : thématique1', 'h2');
        $I->see('reponse1', 'p');
    }
}
