<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UserRepository $userRepository,PostRepository $postRepository): Response
    {
        $liste_userid = [];
        $users = $userRepository->findAll();
        foreach ($users as $user){
            $datenow = new \DateTime();
            $datenow->sub(new \DateInterval('P7D'));
            $userDateCreation =$user->getDateCreation();
            if ($userDateCreation>=$datenow){
                $liste_userid[] = $user;
            }
        }
        $liste_post = $postRepository->findBy([],['date' => 'DESC'], 5);


        return $this->render('home/accueil.html.twig',
            ['controller_name' => 'app_home',
                'newUsers'=>$liste_userid,
                'users'=>$users,
                'newPost'=>$liste_post
        ]);
    }
}
