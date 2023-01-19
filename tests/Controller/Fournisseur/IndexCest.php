<?php

namespace App\Tests\Controller\Fournisseur;

use App\Factory\FournisseurFactory;
use App\Factory\TagFactory;
use App\Factory\TypeMaterielFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    /*
     * Test qui vérifie que l'on peut accéder à la page /fournisseur
     */
    public function IndexCodeSuccessful(ControllerTester $I)
    {
        $I->amOnPage('/fournisseur');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Liste des fournisseurs et des prestataires', 'h1');
    }

    /*
     * Test qui vérifie que l'on voit le liens vers la page profil lorsque qu'un fournisseur est connecté
     */
    public function TestWithConnexionIndex(ControllerTester $I)
    {
        $user = FournisseurFactory::createOne([
            'email' => 'brick@example.fr',
            'firstname' => 'Brice',
            'lastname' => 'Kuca',
            'password' => 'test01',
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fournisseur');
        $I->seeResponseCodeIsSuccessful();
    }

    /*
     * Test qui vérifie que l'on ne voit pas le liens vers le profil lorsque personne n'est connecté
     */
    public function TestWithoutConnexionIndex(ControllerTester $I)
    {
        $I->amOnPage('/fournisseur');
        $I->seeResponseCodeIsSuccessful();
        $I->dontSee('Mon profil', 'a');
    }

    /*
     * Test qui vérifie que tout les fournisseurs s'affichent bien sur la page index
     */
    public function NumberOfFournisseur(ControllerTester $I)
    {
        FournisseurFactory::createOne()->object();
        $I->amOnPage('/fournisseur');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.fournisseur', 1);
    }

    /*
     * Test qui vérifie que le formulaire de recherche de fournisseur est bien présent
     */
    public function FormIsHere(ControllerTester $I)
    {
        $I->amOnPage('/fournisseur');
        $I->seeResponseCodeIsSuccessful();
        $I->seeElement('div', ['class' => 'search_fourni_name']);
        $I->seeElement('input', ['name' => 'searchNomPrenom']);
        $I->seeElement('select', ['name' => 'searchTags']);
    }

    /*
     * Test qui vérifie que la recherche par nom fonctionne bien
     */
    public function SearchByName(ControllerTester $I)
    {
        FournisseurFactory::createOne(['email' => 'brick@example.fr', 'firstname' => 'Brice', 'lastname' => 'Kuca', 'password' => 'test01'])->object();
        FournisseurFactory::createOne(['email' => 'zzzzz@example.fr', 'firstname' => 'zzzzz', 'lastname' => 'zzzz', 'password' => 'test02'])->object();
        $I->amOnPage('/fournisseur');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.fournisseur', 2);
        $I->amOnPage('/fournisseur?searchNomPrenom=Brice&searchTags=');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.fournisseur', 1);
    }

    /*
     * Test qui vérifie que la recherche par tags fonctionne bien
     */
    public function SearchByTags(ControllerTester $I)
    {
        $user = FournisseurFactory::createOne([
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
            'description_materiel' => 'test',
            'intitule_materiel' => 'test',
        ])->object();
        $user->addTypeMaterielPropose($materiel);
        FournisseurFactory::createOne([
            'email' => 'zzzzz@example.fr',
            'firstname' => 'zzzzz',
            'lastname' => 'zzzz',
            'password' => 'test02',
        ])->object();

        $I->amOnPage('/fournisseur');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.fournisseur', 2);
        $I->amOnPage('/fournisseur?searchNomPrenom=&searchTags=Outils');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.fournisseur', 1);
    }
}
