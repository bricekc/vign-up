<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

class UserController extends AbstractController
{
    #[Route('/profil/{id}', name: 'app_user', requirements: ['id' => '\d+'])]
    #[ParamConverter('user', class: 'App\Entity\User')]
    public function show(User $user): Response
    {
        $explodedClassname = explode('\\', get_class($user));
        $className = mb_strtoupper(array_pop($explodedClassname));

        $posts = $user->getPosts();
        $sujets = [];
        foreach ($posts as $post) {
            $sujet = $post->getSujet();
            if (!in_array($sujet, $sujets)) {
                $sujets[] = $sujet;
            }
        }
        $nbposts = count($posts);
        $nbsujets = count($sujets);

        return $this->render('user/index.html.twig',
            ['user' => $user,
                'class' => $className,
                'nbposts' => $nbposts,
                'nbsujets' => $nbsujets, ]);
    }

    #[Route('/profil/update/{id}', name: 'app_update_user', requirements: ['id' => '\d+'])]
    #[ParamConverter('user', class: 'App\Entity\User')]
    public function update(User $user, Request $request, ManagerRegistry $doctrine): Response
    {
        if (null == $this->getUser() or $this->getUser()->getId() !== $user->getId()) {
            return $this->redirectToRoute('app_home');
        }
        $explodedClassname = explode('\\', get_class($user));
        $className = mb_strtoupper(array_pop($explodedClassname));
        $form = $this->createForm(RegistrationFormType::class, $user)
            ->add('photo_upload', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                    ]),
                ]]);
        $form->remove('plainPassword');
        if ('VITICULTEUR' === $className) {
            $form->add('num_siret');
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['photo_upload']->getData();
            $filename = "{$user->getEmail()}.png";
            if ($user->getPhotoProfil() === $filename) {
                unlink('img/photo_profil/'.$filename);
            }
            $file->move('img/photo_profil/', $filename);
            $user->setPhotoProfil($filename);
            $doctrine->getManager()->flush();

            return $this->redirectToRoute('app_user', ['id' => $user->getId()]);
        }

        return $this->renderForm('user/update.html.twig', ['user' => $user, 'form' => $form, 'className' => $className]);
    }

    #[Route('/user/{id}/delete', name: 'app_delete_user', requirements: ['id' => '\d+'])]
    #[ParamConverter('contact', class: 'App\Entity\User')]
    public function delete(User $user, Request $request, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $explodedClassname = explode('\\', get_class($user));
        $className = mb_strtoupper(array_pop($explodedClassname));
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        $entityManager = $doctrine->getManager();
        if ($form->getClickedButton() && 'delete' === $form->getClickedButton()->getName()) {
            $posts = $user->getPosts();
            foreach ($posts as $post) {
                $entityManager->remove($post);
            }
            if ('VITICULTEUR' === $className) {
                $vignes = $user->getVignes();
                foreach ($vignes as $vigne) {
                    $entityManager->remove($vigne);
                }
            }
            $entityManager->remove($user);
            $entityManager->flush();

            return 'VITICULTEUR' == $className ? $this->redirectToRoute('app_verif_viticulteur') : $this->redirectToRoute('app_verif_fournisseur');
        }

        if ($form->getClickedButton() && 'cancel' === $form->getClickedButton()->getName()) {
            return 'VITICULTEUR' == $className ? $this->redirectToRoute('app_verif_viticulteur') : $this->redirectToRoute('app_verif_fournisseur');
        }

        return $this->renderForm('user/delete.html.twig', ['form' => $form, 'user' => $user]);
    }

    #[Route('/user/{id}/verif', name: 'app_verif_user', requirements: ['id' => '\d+'])]
    #[ParamConverter('contact', class: 'App\Entity\User')]
    public function verif(User $user, Request $request, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $explodedClassname = explode('\\', get_class($user));
        $className = mb_strtoupper(array_pop($explodedClassname));
        if (!('VITICULTEUR' == $className || 'FOURNISSEUR' == $className)) {
            $this->redirectToRoute('app_home');
        }
        $form = $this->createFormBuilder()
            ->add('verif', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        $entityManager = $doctrine->getManager();
        if ($form->getClickedButton() && 'verif' === $form->getClickedButton()->getName()) {
            $user->setVerif(true);
            $entityManager->flush();

            return 'VITICULTEUR' == $className ? $this->redirectToRoute('app_verif_viticulteur') : $this->redirectToRoute('app_verif_fournisseur');
        }

        if ($form->getClickedButton() && 'cancel' === $form->getClickedButton()->getName()) {
            return 'VITICULTEUR' == $className ? $this->redirectToRoute('app_verif_viticulteur') : $this->redirectToRoute('app_verif_fournisseur');
        }

        return $this->renderForm('user/verif.html.twig', ['form' => $form, 'user' => $user]);
    }
}
