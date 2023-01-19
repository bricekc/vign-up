<?php

namespace App\Tests\Controller\Sujet;

use App\Factory\AdminFactory;
use App\Factory\PostFactory;
use App\Factory\SujetFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;

class UpdatePostCest
{
    /*fonction qui vérifie que l'auteur d'un post puisse bien avoir le choix de le modifier et vérification que la modification fonctionne bien*/
    public function UserUpdatePost(ControllerTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $user = ViticulteurFactory::createOne();
        $post2 = PostFactory::createOne([
            'sujet' => $post->getSujet(),
            'utilisateur' => $user,
            'date' => new \DateTime(),
            'texte' => 'test',
        ]);
        $sujetId = $post->getSujet()->getId();
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage("/sujet/$sujetId");
        $I->seeNumberOfElements('.update_delete', 2);
        $I->click('edit', '.update_delete');
        $I->amOnPage("/post/{$post2->getId()}/update");
        $I->click('Modifier');
        $I->amOnPage("/sujet/$sujetId");
    }

    /*test qui vérifie qu'une personne connecté ou une personne non connecté ne puisse pas modifier un post qui ne lui appartient pas*/
    public function restricted(ControllerTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $sujetId = $post->getSujet()->getId();
        $I->amOnPage("/sujet/$sujetId");
        $I->seeNumberOfElements('.text-warning', 0);
        $user = AdminFactory::createOne();
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage("/sujet/$sujetId");
        $I->amOnPage("/post/{$post->getId()}/update");
        $I->seeCurrentUrlEquals("/sujet/$sujetId");
    }
}
