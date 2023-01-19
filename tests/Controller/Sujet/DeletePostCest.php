<?php

namespace App\Tests\Controller\Sujet;

use App\Factory\AdminFactory;
use App\Factory\PostFactory;
use App\Factory\SujetFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;

class DeletePostCest {

    /*
     * test qui vérifie qu'un user connecté ou une personne non connecté ne peut pas supprimer un post dans un sujet.
    */
    public function restricted(ControllerTester $I)
    {
        ViticulteurFactory::createMany(8);
        SujetFactory::createMany(5);
        $post = PostFactory::createOne();
        $user = ViticulteurFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
        ]);
        $realUser = $user->object();
        $sujetId = $post->getSujet()->getId();
        $I->amOnPage("/sujet/$sujetId");
        $I->seeNumberOfElements('.text-warning', 0);
        $I->amLoggedInAs($realUser);
        $I->amOnPage("/sujet/$sujetId");
        $I->seeNumberOfElements('.text-warning', 0);
    }
}