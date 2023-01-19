<?php

namespace App\Tests\Controller\Fournisseur;

use App\Factory\FournisseurFactory;
use App\Tests\Support\ControllerTester;

class CreateServiceCest
{
    /*
     * Test qui vérifie que la page renvoit un code successful quand
     * un utilisateur est connecté.
     */
    public function CreateServiceCodeSuccessful(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $I->amLoggedInAs($fournisseur);
        $I->amOnPage('/fournisseur/profil/'.$fournisseur->getId().'/createService');
        $I->seeResponseCodeIsSuccessful();
        $I->see("Création d'un service");
    }

    /*
     * Test qui vérifie que quand on essait de rendre sur la page sans être connecté avec le bon
     * fournisseur on est redirigé vers la page de connexion.
     */
    public function TestWithoutConnexion(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $I->amOnPage('/fournisseur/profil/'.$fournisseur->getId().'/createService');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_login');
    }

    /*
     * Test qui vérifie la structure de la page.
     */
    public function StructurePageCreationService(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $I->amLoggedInAs($fournisseur);
        $I->amOnPage('/fournisseur/profil/'.$fournisseur->getId().'/createService');
        $I->seeResponseCodeIsSuccessful();

        $I->seeElement('h1', ['class' => 'titre_f']);
        $I->seeElement('form', ['class' => 'register_form']);
    }

    /*
     * Test qui vérifie la structure du formulaire de création de TypeMateriel.
     */
    public function StructureFormCreationMateriel(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $I->amLoggedInAs($fournisseur);
        $I->amOnPage('/fournisseur/profil/'.$fournisseur->getId().'/createService');
        $I->seeResponseCodeIsSuccessful();

        $I->see('Titre du service');
        $I->seeElement('input', ['name' => 'type_service[intitule_service]']);
        $I->see('description de votre service');
        $I->seeElement('input', ['name' => 'type_service[description_service]']);
        $I->see('tags de recherche');
        $I->seeElement('select', ['name' => 'type_service[tag]']);
        $I->seeElement('button', ['name' => 'type_service[save]', 'class' => 'user_button_submit']);
    }
}
