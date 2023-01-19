<?php

namespace App\Tests\Controller\Sujet;

use App\Factory\AdminFactory;
use App\Factory\PostFactory;
use App\Factory\SujetFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    /*
     * fonction qui vérifie qu'un utilisateur connecté peut créer un nouveau sujet.
     */
    public function IndexConnect(ControllerTester $I)
    {
        $user = ViticulteurFactory::createOne([
            'email' => 'dio@example.com',
            'firstname' => 'Loëvann',
            'lastname' => 'Guegan',
            'password' => 'adminfloppa01',
            'verif' => true,
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/sujet');
        $I->see("Création d'un sujet", 'h1');
    }

    /*
     * fonction qui permet de vérifié qu'un utilisateur non connecté ne peut pas créer un nouveau sujet et ne peux pas supprimer.
     */
    public function IndexNotConnect(ControllerTester $I)
    {
        $I->amOnPage('/sujet');
        $I->dontSee("Création d'un sujet", 'h1');
        $I->dontSee('delete', '.text-warning');
    }

    /*
     *  Test Permetant de verifier que le nombre de sujet qui s'affiche ne dépasse pas le nombre choisi dans la pagination.
     */
    public function NumberOfSujetPerPage(ControllerTester $I)
    {
        SujetFactory::createMany(9);
        $numberSujet = 5;
        $I->amOnPage('/sujet');
        $I->seeNumberOfElements('.sujet', $numberSujet + 1);
        $I->click('>');
        $I->seeNumberOfElements('.sujet', 4 + 1);
    }

    public function SeePostOnSujet(ControllerTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $sujet_name = $post->getSujet()->getIntituleSujet();
        $text = $post->getTexte();
        $I->amOnPage('/sujet');
        $I->click($sujet_name);
        $I->seeCurrentRouteIs('app_sujet_id');
        $I->see($text, '.post');
    }

    /* vérifie que quand un utilisateur est connecté il peut voir le bouton de suppression de sujet */
    public function adminConnect(ControllerTester $I)
    {
        $user = AdminFactory::createOne([
            'email' => 'dio@example.com',
            'firstname' => 'Loëvann',
            'lastname' => 'Guegan',
            'password' => 'adminfloppa01',
        ]);
        SujetFactory::createMany(5);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/sujet');
        $I->see('delete', '.text-warning');
        $I->seeNumberOfElements('.text-warning', 5);
    }
}
