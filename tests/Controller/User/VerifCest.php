<?php

namespace App\Tests\Controller\User;

use App\Factory\AdminFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;

class VerifCest
{
    /*
     * fonction qui vérifie qu'une personne non connecté ne puisse pas aller valider un compte
     */
    public function verifnotconnected(ControllerTester $I)
    {
        ViticulteurFactory::createOne();
        $I->amOnPage('/user/1/verif');
        $I->seeCurrentUrlEquals('/login');
    }

    /*
     * fonction qui vérifie qu'une personne connecté ne puisse pas aller valider un compte
     */
    public function verifconnected(ControllerTester $I)
    {
        $Viticulteur = ViticulteurFactory::createOne();
        $I->amLoggedInAs($Viticulteur->object());
        $I->amOnPage('/user/1/verif');
        $I->seeResponseCodeIs(403);
    }

    /*
     * fonction qui vérifie qu'une personne connecté en tant qu'admin puisse aller valider un compte
     */
    public function verifadmin(ControllerTester $I)
    {
        $admin = AdminFactory::createOne();
        $I->amLoggedInAs($admin->object());
        $I->amOnPage('/user/1/verif');
        $I->seeResponseCodeIs(200);
    }
}