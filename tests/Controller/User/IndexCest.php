<?php

namespace App\Tests\Controller\User;

use App\Factory\FournisseurFactory;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    /*
     * fonction qui vérifie qu'un utilisateur pas connecté puisse voir les infos de l'utilisateur.
     * ne puisse pas le modifier
     */
    public function ProfilNotConnected(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne();
        $I->amOnPage('/profil/1');
        $I->see('Cet utilisateur est un FOURNISSEUR', '.class_user');
        $I->see($fournisseur->getEmail(), '.user_email');
        $I->see($fournisseur->getAdresse(), '.user_adresse');
        $I->SeeElement('.user_button_submit');
        $I->dontSeeElement('.user_button_cancel');
    }

    /*
     * fonction qui vérifie qu'un utilisateur connecté puisse voir les infos de l'utilisateur.
     * avec la possibilité de modifier son profil ou de se déconnecter
     */
    public function ProfilConnected(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne();
        $I->amLoggedInAs($fournisseur->object());
        $I->amOnPage('/profil/1');
        $I->see('Cet utilisateur est un FOURNISSEUR', '.class_user');
        $I->see($fournisseur->getEmail(), '.user_email');
        $I->see($fournisseur->getAdresse(), '.user_adresse');
        $I->seeElement('.user_button_submit');
        $I->seeElement('.user_button_cancel');
    }

    /*
     * fonction qui vérifié qu'une personne connecté ne puisse pas modifier les infos
     * d'un autre utilisateur
     */
    public function RestrictionProfilConnected(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne();
        $fournisseur2 = FournisseurFactory::createOne();
        $I->amLoggedInAs($fournisseur->object());
        $I->amOnPage('/profil/2');
        $I->dontSeeElement('.user_button_cancel');
    }
}
