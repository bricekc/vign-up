<?php

namespace App\Tests\Controller\Sujet;

use App\Factory\AdminFactory;
use App\Factory\PostFactory;
use App\Factory\SujetFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    /*
     * fonction qui vérifie qu'un utilisateur connecté peut créer un post dans un sujet.
     */
    public function ShowConnect(ControllerTester $I)
    {
        SujetFactory::createOne([
            'intitule_sujet' => 'OMG 1er Sujet ????',
        ]);
        $user = ViticulteurFactory::createOne([
            'email' => 'dio@example.com',
            'firstname' => 'Loëvann',
            'lastname' => 'Guegan',
            'password' => 'adminfloppa01',
            'verif' => true,
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/sujet/1');
        $I->seeNumberOfElements('h1', 2);
    }

    /*
     * fonction qui vérifie qu'un utilisateur non connecté ne peut pas créer un post dans un sujet et ne peut pas modifier ni supprimer.
     */
    public function ShowNotConnect(ControllerTester $I)
    {
        SujetFactory::createOne([
            'intitule_sujet' => 'OMG 1er Sujet ????',
        ]);
        $I->amOnPage('/sujet/1');
        $I->dontSee('Nouveau Post', 'h1');
        $I->dontSee('delete', '.text-warning');
        $I->dontSee('edit', '.text-warning');
    }

    /*
     * Test qui regarde si le nom de l'utilisateur et la date est bien affiché avec le post.
     */
    public function SeeUserAndDate(ControllerTester $I)
    {
        $viticulteur = ViticulteurFactory::createOne();
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $sujetId = $post->getSujet()->getId();
        $userName = $post->getUtilisateur()->getFirstname();
        $date_string = $post->getDate()->format('d/m/Y H:i:s');
        $I->amLoggedInAs($viticulteur->object());
        $I->amOnPage("/sujet/$sujetId");
        $I->see($userName, '.forum_name_avatar');
        $I->see($date_string, '.date_forum');
    }
}
