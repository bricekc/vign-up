<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\FournisseurRepository;
use App\Repository\UserRepository;
use App\Repository\ViticulteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * Cette fonction permet d'afficher la page d'inscription.
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserRepository $repository): Response
    {
        if (null !== $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        // création d'un nouveau use
        $user = new User();
        // création du formulaire d'inscription avec en choix de s'inscrire en tant que viticulteur ou fournisseur
        $form = $this->createForm(RegistrationFormType::class, $user)
            ->add('viticulteur', SubmitType::class, ['label' => 'Viticulteur', 'attr' => ['class' => 'register_button']])
            ->add('fournisseur', SubmitType::class, ['label' => 'Fournisseur', 'attr' => ['class' => 'register_button']]);
        $form->handleRequest($request);

        // si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // hashage du mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setPhotoProfil('default_avatar.png');
            // si le formulaire est cliqué avec le bouton viticulteur
            if ($form->getClickedButton() && 'viticulteur' === $form->getClickedButton()->getName()) {
                // enregistrement du user dans la bd
                $entityManager->persist($user);
                $entityManager->flush();
                // ajout de la valeur viticulteur dans la bd
                $query = "UPDATE user SET discriminator = 'viticulteur' WHERE id =".$user->getId();
                // lance la requête sql
                $entityManager->getConnection()->exec($query);
                // met le numéro de siret à zéro par default
                $query = 'INSERT INTO viticulteur (id, verif, num_siret) values ('.$user->getId().', 0, 0)';
                // lance la requête sql
                $entityManager->getConnection()->exec($query);
            }
            // si le formulaire est cliqué avec le bouton fournisseur
            elseif ($form->getClickedButton() && 'fournisseur' === $form->getClickedButton()->getName()) {
                // enregistrement du user dans la bd
                $entityManager->persist($user);
                $entityManager->flush();
                // ajout de la valeur fournisseur dans la bd
                $query = "UPDATE user SET discriminator = 'fournisseur' WHERE id =".$user->getId();
                // lance la requête sql
                $entityManager->getConnection()->exec($query);
                // ajout de l'id de l'utilisateur dans la table fournisseur
                $query = 'INSERT INTO fournisseur (id, verif) values ('.$user->getId().', 0)';
                $entityManager->getConnection()->exec($query);
            }

            // redirection vers la page d'accueil
            return $this->redirectToRoute('app_home');
        }

        // affichage de la page d'inscription
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /*
        * Cette fonction permet de vérifier un viticulteur
        */
    #[Route('/register/verif/viticulteur', name: 'app_verif_viticulteur')]
    public function registerVerif(ViticulteurRepository $vitiRepository): Response
    {
        // vérification que l'utilisateur est un admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // récupération de tous les viticulteurs non vérifiés
        $vitis = $vitiRepository->searchNonVerif();

        // affichage de la page de vérification des viticulteurs
        return $this->render('registration/verifViti.html.twig', [
            'vitis' => $vitis,
        ]);
    }

    /*
        * Cette fonction permet de vérifier un fournisseur
        */
    #[Route('/register/verif/fournisseur', name: 'app_verif_fournisseur')]
    public function registerVerifFourn(FournisseurRepository $fournRepository): Response
    {
        // vérification que l'utilisateur est un admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // récupération de tous les fournisseurs non vérifiés
        $fourns = $fournRepository->searchNonVerif();

        // affichage de la page de vérification des fournisseurs
        return $this->render('registration/verifFourn.html.twig', [
            'fourns' => $fourns,
        ]);
    }
}
