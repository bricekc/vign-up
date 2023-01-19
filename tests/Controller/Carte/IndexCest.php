<?php

namespace App\Tests\Controller\Carte;

use App\Factory\VigneFactory;
use App\Factory\ViticulteurFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    /*
     * methode pour tester que la carte s'affiche bien
     */
    public function testIndex(ControllerTester $I)
    {
        $viticulteur = ViticulteurFactory::createOne();
        VigneFactory::createOne(['latitude' => 49.238211, 'longitude' => 4.054935, 'viticulteur' => $viticulteur->object()]);
        $I->amOnPage('/carte');
        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('div#map', 1);
        $I->see('Informations sur le vigneron :', 'p');
        $I->see('Profil du vigneron', '#button_carte');
    }
}
