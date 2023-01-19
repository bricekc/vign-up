<?php

namespace App\Tests\Controller\Fournisseur;

use App\Factory\FournisseurFactory;
use App\Tests\Support\ControllerTester;

class CreateMaterielCest
{
    /*
     * Test qui vérifie que la page renvoit un code successful quand
     * un utilisateur est connecté.
     */
    public function CreateMaterielCodeSuccessful(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $I->amLoggedInAs($fournisseur);
        $I->amOnPage('/fournisseur/profil/'.$fournisseur->getId().'/createMateriel');
        $I->seeResponseCodeIsSuccessful();
        $I->see("Création d'un materiel");
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
        $I->amOnPage('/fournisseur/profil/'.$fournisseur->getId().'/createMateriel');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_login');
    }

    /*
     * Test qui vérifie la structure de la page.
     */
    public function StructurePageCreationMateriel(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $I->amLoggedInAs($fournisseur);
        $I->amOnPage('/fournisseur/profil/'.$fournisseur->getId().'/createMateriel');
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
        $I->amOnPage('/fournisseur/profil/'.$fournisseur->getId().'/createMateriel');
        $I->seeResponseCodeIsSuccessful();

        $I->see('Titre du materiel');
        $I->seeElement('input', ['name' => 'type_materiel[intitule_materiel]']);
        $I->see('description de votre materiel');
        $I->seeElement('input', ['name' => 'type_materiel[description_materiel]']);
        $I->see('tags de recherche');
        $I->seeElement('select', ['name' => 'type_materiel[tag]']);
        $I->seeElement('button', ['name' => 'type_materiel[save]', 'class' => 'user_button_submit']);
    }
}
