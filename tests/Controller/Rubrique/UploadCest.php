<?php

namespace App\Tests\Controller\Rubrique;

use App\Factory\AdminFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;

class UploadCest
{
    /*
     * test qui vérifie qu'un utilisateur non connecté ne puisse pas accéder
     *  à la page d'upload d'un fichier
     */
    public function restrictionNotConnected(ControllerTester $I)
    {
        $I->amOnPage('/rubrique/upload');

        $I->seeCurrentUrlEquals('/login');
    }

    /*
     * test qui vérifie qu'un utilisateur connecté ne puisse pas accéder
     *  à la page d'upload d'un fichier
     */
    public function restrictionConnected(ControllerTester $I)
    {
        $user = ViticulteurFactory::createOne();
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/rubrique/upload');
        $I->seeResponseCodeIs(403);
    }

    /*
     * test qui vérifie qu'un administrateur connecté puisse accéder
     *  à la page d'upload d'un fichier
     */
    public function restrictionAdmin(ControllerTester $I)
    {
        $user = AdminFactory::createOne();
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/rubrique');
        $I->click('Ajouter', '.rubrique_button_add');
        $I->seeCurrentUrlEquals('/rubrique/upload');
    }
}
