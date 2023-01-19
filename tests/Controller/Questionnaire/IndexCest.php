<?php

namespace App\Tests\Controller\Questionnaire;

use App\Factory\QuestionnaireFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    /*
     * Test qui vérifie que l'on vois bien la page questionnaire
     * avec le nombre de questionnaire créer
     */
    public function Index(ControllerTester $I)
    {
        QuestionnaireFactory::createMany(3);
        $I->amOnPage('/questionnaire');
        $I->seeNumberOfElements('.BoxQuestionnaire', 3);
    }
}