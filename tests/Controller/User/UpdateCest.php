<?php

namespace App\Tests\Controller\User;

use App\Factory\FournisseurFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
    /*
     * fonction qu'un utilisateur connecté puisse aller sur sa page de modification
     */
    public function connectedGoUpdate(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne();
        $I->amLoggedInAs($fournisseur->object());
        $I->amOnPage('/profil/1');
        $I->click('.user_button_submit');
        $I->amOnPage('/profil/update/1');
    }
}