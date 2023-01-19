<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * Cette fonction permet de supprimer un post.
     */
    #[Route('/post/{id}/delete', name: 'app_post_delete')]
    public function deletePost(Request $request, ManagerRegistry $doctrine, Post $post): Response
    {
        // vérification que l'utilisateur est un admin ou l'utilisateur qui a posté le post
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!($this->getUser()->getId() === $post->getUtilisateur()->getId()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_sujet');
        }
        $entityManager = $doctrine->getManager();
        // création du formulaire pour supprimer le post
        $form = $this->createFormBuilder($post)
            ->add('delete', SubmitType::class, ['label' => 'Supprimer', 'attr' => ['class' => 'btn btn-primary']])
            ->add('cancel', SubmitType::class, ['label' => 'Annuler', 'attr' => ['class' => 'btn btn-secondary']])
            ->getForm();
        $form->handleRequest($request);
        // si l'admin choisi de supprimer un post
        if ($form->getClickedButton() && 'delete' === $form->getClickedButton()->getName()) {
            // supprime le post dans la bd
            $entityManager->remove($post);
            $entityManager->flush();

            // redirige vers la page du sujet
            return $this->redirectToRoute('app_sujet_id', ['id' => $post->getSujet()->getId()]);
        }
        // si l'admin choisit d'annuler la suppression
        if ($form->getClickedButton() && 'cancel' === $form->getClickedButton()->getName()) {
            // redirige vers la page du sujet
            return $this->redirectToRoute('app_sujet_id', ['id' => $post->getSujet()->getId()]);
        }

        // affiche la page de suppression du post
        return $this->renderForm('post/deletePost.html.twig', ['post' => $post, 'form' => $form]);
    }

    /**
     * Cette fonction permet de modifier un post.
     */
    #[Route('/post/{id}/update', name: 'app_post_update')]
    public function updatePost(Request $request, ManagerRegistry $doctrine, Post $post): Response
    {
        // vérification que l'utilisateur est bien la personne qui a écrit le post
        if (null != $this->getUser() && $this->getUser()->getId() === $post->getUtilisateur()->getId()) {
            $entityManager = $doctrine->getManager();
            // création du formulaire pour modifier un post
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);
            // si le formulaire est valide
            if ($form->isSubmitted() && $form->isValid()) {
                // modifie le post dans la bd
                $entityManager->flush();
                // redirection vers la page du sujet avec ses posts
                return $this->redirectToRoute('app_sujet_id', ['id' => $post->getSujet()->getId()]);
            }

            // affiche le formulaire pour modifier un post
            return $this->renderForm('post/updatePost.html.twig', [
                'form' => $form, 'post' => $post,
            ]);
        } else {
            // redirige vers la page du sujet
            return $this->redirectToRoute('app_sujet_id', ['id' => $post->getSujet()->getId()]);
        }
    }
}
