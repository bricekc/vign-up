<?php

namespace App\Tests\Controller\Fournisseur;

use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\TypeMaterielFactory;
use App\Factory\TypeServiceFactory;
use App\Tests\Support\ControllerTester;

class showCest
{
    /*
     * Test qui vérifie que l'on peut se rendre sur la page show avec un code de responce valide.
     */
    public function ShowCodeSuccessful(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $I->amOnPage('/fournisseur/'.$fournisseur->getId());
        $I->seeResponseCodeIsSuccessful();
        $I->see('Materiels et Services proposés par '.$fournisseur->getFirstname().' '.$fournisseur->getLastname(), 'h1');
    }

    /*
     * Test qui vérifie que le liens vers la page du fournisseur est bien présent sur la page index fournisseur.
     */
    public function IndexLinkToShow(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();

        $I->amOnPage('/fournisseur');
        $I->seeResponseCodeIsSuccessful();
        $I->seeElement('a', ['href' => '/fournisseur/'.$fournisseur->getId()]);

        $I->click($fournisseur->getFirstname().' '.$fournisseur->getLastname());
        $I->seeCurrentRouteIs('app_fournisseur_show');
        $I->see('Materiels et Services proposés par '.$fournisseur->getFirstname().' '.$fournisseur->getLastname(), 'h1');
    }

    /*
     * Test qui vérifie la structure de la page show et qui vérifie la présence
     * de toutes les informations sur le fournisseur et sur ses services/materiel.
     */
    public function StructureOfShowPage(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $tags = TagFactory::createOne([
            'nom' => 'Outils',
        ])->object();
        $materiel = TypeMaterielFactory::createOne([
            'tag' => $tags,
            'description_materiel' => 'testMateriel',
            'intitule_materiel' => 'testMateriel',
        ])->object();
        $service = TypeServiceFactory::createOne([
            'tag' => $tags,
            'description_service' => 'testService',
            'intitule_service' => 'testService',
        ])->object();
        $fournisseur->addTypeMaterielPropose($materiel);
        $fournisseur->addTypeServicePropose($service);
        $I->amOnPage('/fournisseur/'.$fournisseur->getId());
        $I->seeResponseCodeIsSuccessful();

        $I->see('Materiels et Services proposés par '.$fournisseur->getFirstname().' '.$fournisseur->getLastname(), 'h1');
        $I->seeElement('div', ['class' => 'fournisseur_desc']);
        $I->seeElement('div', ['class' => 'fournisseur']);
        $I->seeElement('div', ['class' => 'fournisseur_image_and_name']);
        $I->seeElement('img', ['class' => 'image_fournisseur']);
        $I->seeElement('p', ['class' => 'user_name']);
        $I->see($fournisseur->getFirstname().' '.$fournisseur->getLastname(), 'p');
        $I->seeElement('div', ['class' => 'materiel_service']);
        $I->seeElement('div', ['class' => 'materiels']);
        $I->seeElement('div', ['class' => 'services']);
    }

    /*
     * Test qui vérifie si le liens vers le profil du fournisseur est présent dans la page show et qi il renvoit sur la bonne page.
     */
    public function LinkToProfil(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();

        $I->amOnPage('/fournisseur/'.$fournisseur->getId());
        $I->seeResponseCodeIsSuccessful();

        $I->see('Materiels et Services proposés par '.$fournisseur->getFirstname().' '.$fournisseur->getLastname(), 'h1');
        $I->seeElement('a', ['href' => '/profil/'.$fournisseur->getId()]);
        $I->seeElement('button', ['class' => 'user_button_submit']);
        $I->click('Acceder au profil');
        $I->seeCurrentRouteIs('app_user');
        $I->see('Cet utilisateur est un FOURNISSEUR');
        $I->see($fournisseur->getFirstname().' '.$fournisseur->getLastname());
    }

    /*
     * Test qui vérifie que la page s'affiche bien quand un utilisateur est connecté.
     */
    public function TestWithConnexionShow(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $I->amLoggedInAs($fournisseur);
        $I->amOnPage('/fournisseur/'.$fournisseur->getId());
        $I->seeResponseCodeIsSuccessful();
    }

    /*
     * Test qui vérifie la présence de tout les liens nécessaires quand l'utilisateur à qui appartient la page show est connecté.
     */
    public function StructureOfShowPageWithConnexion(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $I->amLoggedInAs($fournisseur);
        $I->amOnPage('/fournisseur/'.$fournisseur->getId());
        $I->seeResponseCodeIsSuccessful();

        $I->seeElement('a', ['href' => '/fournisseur/profil/'.$fournisseur->getId().'/createMateriel']);
        $I->seeElement('a', ['href' => '/fournisseur/profil/'.$fournisseur->getId().'/createService']);
        $I->seeElement('button', ['class' => 'user_button_submit']);
        $I->see('Ajouter un type de materiel');
        $I->see('Ajouter un type de service');
    }

    /*
     * Test qui vérifie que les liens pour modification de la page show ne sont pas présent quand le fournisseur concerné n'est pas connecté.
     */
    public function StructureOfPageWithoutConnexion(ControllerTester $I)
    {
        $fournisseur = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ])->object();
        $I->amOnPage('/fournisseur/'.$fournisseur->getId());
        $I->seeResponseCodeIsSuccessful();

        $I->dontSeeElement('a', ['href' => '/fournisseur/profil/'.$fournisseur->getId().'/createMateriel']);
        $I->dontSeeElement('a', ['href' => '/fournisseur/profil/'.$fournisseur->getId().'/createService']);
        $I->dontSee('Ajouter un type de materiel');
        $I->dontSee('Ajouter un type de service');
    }
}
