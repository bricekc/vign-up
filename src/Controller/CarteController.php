<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\VigneRepository;
use App\Repository\ViticulteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Zenstruck\Foundry\repository;

class CarteController extends AbstractController
{
    #[Route('/carte', name: 'app_carte')]
    public function index(VigneRepository $repositoryVigne,UserRepository $repositoryUser): Response
    {
        $coordvignes = [];
        $vignes = $repositoryVigne->findAll();
        foreach ($vignes as $vigne) {
            $idVigneron = $vigne->getViticulteur()->getId();
            $vignerons[$idVigneron] = $vigne->getViticulteur();
            $latitude = $vigne->getLatitude();
            $longitude = $vigne->getLongitude();

            if (!isset($coordvignes[$idVigneron])) {
                $coordvignes[$idVigneron] = [];
            }
            $coordvignes[$idVigneron][] = ['lat' => $latitude, 'lng' => $longitude];
        }
        $users = $repositoryUser->findAll();
        foreach ($users as $user){
            $user_adresse = $user->getAdresse();


        }

        return $this->render('carte/index.html.twig', [
            'coordvignes' => $coordvignes,
            'vignerons' => $vignerons,
            'adresse' => $user_adresse
            ]);
    }
}

/*$longitude, $latitude
$listuser = $this->->getRepository(::class)->findAll();

$userId = $this->get('session')->get('user_id');

       $list = [
   ['lat' => 51.5, 'lng' => -0.09],
   ['lat' => 51.51, 'lng' => -0.089],
   ['lat' => 51.52, 'lng' => -0.091]
       ];



];
$vignerons['id'=>['lat' => 51.5, 'lng' => -0.09],
   ['lat' => 51.51, 'lng' => -0.089],
   ['lat' => 51.52, 'lng' => -0.091]]

return $this->render('carte/index.html.twig', [
    'controller_name' => 'CarteController',

]);
    }
}*/
