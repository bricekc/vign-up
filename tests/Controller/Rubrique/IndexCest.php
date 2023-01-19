<?php

namespace App\Tests\Controller\Rubrique;

use App\Factory\AdminFactory;
use App\Factory\RubriqueFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    /*
     * Test qui vérifie qu'une personne non connecté
     * ne peut pas accéder à la page de création d'une rubrique
     * peut télécharger un fichier
     * ne peut pas supprimer un fichier
     */
    public function NotConnected(ControllerTester $I)
    {
        RubriqueFactory::createOne([
            'titre' => 'test',
            'filename' => '/test',
        ]);
        $I->amOnPage('/rubrique');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Liste des Rubriques', 'h2');
        $I->dontSee('Ajouter', '.rubrique_button_add');
        $I->see('Télécharger', '.rubrique_button_download');
        $I->dontSee('Supprimer', '.rubrique_button_delete');
    }

    /*
     * Test qui vérifie qu'un utilisateur connecté
     * ne peut pas accéder à la page de création d'une rubrique
     * peut télécharger un fichier
     * ne peut pas supprimer un fichier
     */
    public function Connected(ControllerTester $I)
    {
        $user = ViticulteurFactory::createOne();
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        RubriqueFactory::createOne([
            'titre' => 'test',
            'filename' => '/test',
        ]);
        $I->amOnPage('/rubrique');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Liste des Rubriques', 'h2');
        $I->dontSee('Ajouter', '.rubrique_button_add');
        $I->see('Télécharger', '.rubrique_button_download');
        $I->dontSee('Supprimer', '.rubrique_button_delete');
    }

    /*
     * Test qui vérifie qu'un administrateur connecté
     * peut accéder à la page de création d'une rubrique
     * peut télécharger un fichier
     * peut supprimer un fichier
     */
    public function AdminConnected(ControllerTester $I)
    {
        $user = AdminFactory::createOne();
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        RubriqueFactory::createOne([
            'titre' => 'test',
            'filename' => '/test',
        ]);
        $I->amOnPage('/rubrique');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Liste des Rubriques', 'h2');
        $I->see('Ajouter', '.rubrique_button_add');
        $I->see('Télécharger', '.rubrique_button_download');
        $I->see('Supprimer', '.rubrique_button_delete');
    }
}
