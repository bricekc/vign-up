<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Sujet;
use App\Form\PostType;
use App\Form\SujetType;
use App\Repository\PostRepository;
use App\Repository\SujetRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SujetController extends AbstractController
{
    /**
     * Cette fonction permet d'afficher la liste des sujets, avec une pagination de 5 sujets par page
     * Elle prend en compte une recherche de sujets par leur titre
     * Elle permet la création d'un nouveau sujet.
     */
    #[Route('/sujet', name: 'app_sujet')]
    public function index(Request $request, SujetRepository $repository, SujetRepository $service, PaginatorInterface $paginator): Response
    {
        $search = $request->query->get('search', '');
        // récupération de la liste des sujets en fonction de la rechercher qui renvoie
        // par default tout les sujets
        $sujets = $repository->search($search);
        // pagination des résultats sur la page 1 par défault
        $sujets = $paginator->paginate(
            $sujets,
            $request->query->getInt('page', 1),
            5
        );
        // création d'un nouveau sujet
        $sujet = new Sujet();
        // création du formulaire pour la création d'un nouveau sujet
        $form = $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // sauvegarde du nouveau sujet
            $service->save($sujet, true);

            // redirection vers la page du nouveau sujet
            return $this->redirectToRoute('app_sujet_id', ['sujet' => $sujet, 'id' => $sujet->getId()]);
        }

        // affichage de la vue avec tout les sujets
        return $this->renderForm('sujet/index.html.twig', [
            'sujets' => $sujets, 'form' => $form,
        ]);
    }

    /**
     * Cette fonction permet d'afficher un sujet et ses posts
     * Elle permet la création d'un nouveau post.
     */
    #[Route('/sujet/{id<\d+>}', name: 'app_sujet_id')]
    public function show(Request $request, PostRepository $service, Sujet $sujet, SujetRepository $sujetRepository, PaginatorInterface $paginator): Response
    {
        // Création d'un nouveau post pour le sujet
        $post = new Post();
        $post->setSujet($sujet);
        $post->setUtilisateur($this->getUser());
        $post->setDate(new \DateTime());
        // création d'un nouveau post pour le sujet
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // sauvegarde du nouveau post
            $service->save($post, true);
            $sujet->setDateLastUpdate($post->getDate());
            $sujetRepository->save($sujet, true);

            // redirection vers la page du sujet
            return $this->redirectToRoute('app_sujet_id', ['id' => $post->getSujet()->getId()]);
        }
        // pagination des posts du sujet sur la page 1 par défault
        $posts = $paginator->paginate(
            $sujet->getPosts(),
            $request->query->getInt('page', 1),
            5
        );

        // affichage de la vue avec le sujet et ses posts
        return $this->renderForm('sujet/show.html.twig', [
            'posts' => $posts, 'form' => $form, 'sujet' => $sujet,
        ]);
    }

    /**
     * Cette fonction permet de supprimer un sujet avec tout ses posts
     * Elle redirige vers la page de la liste des sujets.
     */
    #[Route('/sujet/{id}/delete', name: 'app_sujet_id_delete')]
    public function deleteSujet(Request $request, ManagerRegistry $doctrine, Sujet $sujet): Response
    {
        // vérification que l'utilisateur est un admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager = $doctrine->getManager();
        // création du formulaire de suppression
        $form = $this->createFormBuilder($sujet)
            ->add('delete', SubmitType::class, ['label' => 'Supprimer', 'attr' => ['class' => 'btn btn-primary']])
            ->add('cancel', SubmitType::class, ['label' => 'Annuler', 'attr' => ['class' => 'btn btn-secondary']])
            ->getForm();
        $form->handleRequest($request);
        // si le formulaire est soumis est valide et qu'il décide de supprimer le sujet
        if ($form->getClickedButton() && 'delete' === $form->getClickedButton()->getName()) {
            $posts = $sujet->getPosts();
            // suppression de tout les posts du sujet
            foreach ($posts as $post) {
                $entityManager->remove($post);
            }
            // suppression du sujet
            $entityManager->remove($sujet);
            $entityManager->flush();

            // redirection vers la page de la liste des sujets
            return $this->redirectToRoute('app_sujet');
        }
        // si il décide d'annuler la suppression du sujet et de ses posts
        if ($form->getClickedButton() && 'cancel' === $form->getClickedButton()->getName()) {
            // redirection vers la page du sujet
            return $this->redirectToRoute('app_sujet');
        }

        // affichage de la vue avec le formulaire de suppression
        return $this->renderForm('sujet/deleteSujet.html.twig', ['sujet' => $sujet, 'form' => $form]);
    }
}
