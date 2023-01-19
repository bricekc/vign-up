<?php

namespace App\Tests\Controller\Sujet;

use App\Entity\Viticulteur;
use App\Factory\AdminFactory;
use App\Factory\SujetFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;

class DeleteSujetCest
{
    /*
     * fonction qu'un admin arrive à supprimer un sujet.
     */
    public function form(ControllerTester $I)
    {
        $user = AdminFactory::createOne([
            'email' => 'admin@example.com',
            'roles' => ['ROLE_ADMIN'],
            'password' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
        ]);
        SujetFactory::createMany(1);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/sujet');
        $I->seeNumberOfElements('.text-warning', 1);
        $I->click('delete', '.text-warning');
        $I->seeNumberOfElements('.text-warning', 0);
    }

    /*
     * fonction qui vérifie qu'un user connecté ou une personne non connecté ne peut pas supprimer un sujet.
     */
    public function restricted(ControllerTester $I)
    {
        $user = ViticulteurFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
        ]);
        SujetFactory::createMany(1);
        $I->amOnPage('/sujet');
        $I->seeNumberOfElements('.text-warning', 0);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/sujet');
        $I->seeNumberOfElements('.text-warning', 0);
    }
}
