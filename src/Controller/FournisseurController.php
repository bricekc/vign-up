<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Entity\TypeMateriel;
use App\Entity\TypeService;
use App\Form\TypeMaterielType;
use App\Form\TypeServiceType;
use App\Repository\FournisseurRepository;
use App\Repository\TagRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FournisseurController extends AbstractController
{
    /*
     * Route menant à la page index avec la liste de tout les fournisseurs
     */
    #[Route('/fournisseur', name: 'app_fournisseur')]
    public function index(FournisseurRepository $fournisseur, Request $request, TagRepository $tag): Response
    {
        /*
         * Récupération des noms de tout les tags pour les mettres dans le tableau $all_tags
         */
        $tags = $tag->findAll();
        $all_tags = [];
        foreach ($tags as $tag_) {
            array_push($all_tags, $tag_->getNom());
        }

        /*
         * Récupération des saisie du formulaire de tri des fournisseur dans la query string
         */
        $paramNomPrenom = $request->query->get('searchNomPrenom');
        $paramTags = $request->query->get('searchTags');
        if (null == $paramNomPrenom) {
            $paramNomPrenom = '';
        }
        if (null == $paramTags) {
            $paramTags = 'Rechercher un Tag';
        }

        $listeFournisseur = $fournisseur->searchWithNomPrenom($paramNomPrenom);
        $liste_tags_fournisseur = [];
        $liste_image = [];
        $liste_all_tags = [];

        /*
         * création d'un tableau repertoriant tout les tags utilisés par les fournisseurs et ce, sans doublons
         */
        foreach ($listeFournisseur as $fournisseur_1) {
            foreach ($fournisseur_1->getTypeMaterielPropose() as $materiel_1) {
                if (!in_array($materiel_1->getTag()->getNom(), $liste_all_tags)) {
                    array_push($liste_all_tags, $materiel_1->getTag()->getNom());
                }
            }
            foreach ($fournisseur_1->getTypeServicePropose() as $service_1) {
                if (!in_array($service_1->getTag()->getNom(), $liste_all_tags)) {
                    array_push($liste_all_tags, $service_1->getTag()->getNom());
                }
            }
        }

        /*
         * selection de tout les fournisseurs qui possèdent le tag choisie pour l'utilisateur
         */
        if ('Rechercher un Tag' != $paramTags) {
            $listeFournisseurTemporaire = [];
            foreach ($listeFournisseur as $fournisseur_2) {
                $listeTags = [];
                foreach ($fournisseur_2->getTypeMaterielPropose() as $materielTags) {
                    array_push($listeTags, $materielTags->getTag()->getNom());
                }
                foreach ($fournisseur_2->getTypeServicePropose() as $serviceTags) {
                    array_push($listeTags, $serviceTags->getTag()->getNom());
                }
                if (in_array($paramTags, $listeTags)) {
                    array_push($listeFournisseurTemporaire, $fournisseur_2);
                }
            }
            $listeFournisseur = $listeFournisseurTemporaire;
        }

        /*
         * création d'un tableau associatif qui permet l'affichage des tags de chaque utilisateur sans doublons
         */
        foreach ($listeFournisseur as $fourni) {
            $liste_tags_fournisseur[(string) $fourni->getId()] = ['materiel' => [], 'service' => []];
            foreach ($fourni->getTypeMaterielPropose() as $materiel) {
                if (!in_array($materiel->getTag()->getNom(), $liste_tags_fournisseur[(string) $fourni->getId()]['materiel'])) {
                    array_push($liste_tags_fournisseur[(string) $fourni->getId()]['materiel'], $materiel->getTag()->getNom());
                }
            }
            foreach ($fourni->getTypeServicePropose() as $service) {
                if (!in_array($service->getTag()->getNom(), $liste_tags_fournisseur[(string) $fourni->getId()]['service'])) {
                    array_push($liste_tags_fournisseur[(string) $fourni->getId()]['service'], $service->getTag()->getNom());
                }
            }
        }

        return $this->render('fournisseur/index.html.twig', [
            'liste_fournisseur' => $listeFournisseur,
            'liste_tags_fournisseur' => $liste_tags_fournisseur,
            'search' => $paramNomPrenom,
            'liste_all_tags' => $liste_all_tags,
            'all_tag' => $all_tags,
            'param_tag' => $paramTags,
        ]);
    }

    /*
     * Route menant à la page show montrant les informations du fournisseur correspondant à l'id dans l'url
     */
    #[Route('/fournisseur/{id<\d+>}', name: 'app_fournisseur_show')]
    public function show(Fournisseur $fournisseur): Response
    {
        /*
         * création d'un tableau associatif qui permet l'affichage des tags de chaque utilisateur sans doublons
         */
        $liste_tags_fournisseur = [(string) $fournisseur->getId() => ['materiel' => [], 'service' => []]];
        foreach ($fournisseur->getTypeMaterielPropose() as $materiel) {
            if (!in_array($materiel->getTag()->getNom(), $liste_tags_fournisseur[(string) $fournisseur->getId()]['materiel'])) {
                array_push($liste_tags_fournisseur[(string) $fournisseur->getId()]['materiel'], $materiel->getTag()->getNom());
            }
        }
        foreach ($fournisseur->getTypeServicePropose() as $service) {
            if (!in_array($service->getTag()->getNom(), $liste_tags_fournisseur[(string) $fournisseur->getId()]['service'])) {
                array_push($liste_tags_fournisseur[(string) $fournisseur->getId()]['service'], $service->getTag()->getNom());
            }
        }

        return $this->render('fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
            'liste_tags_fournisseur' => $liste_tags_fournisseur,
        ]);
    }

    /*
     * Route menant à la page où il y a le formulaire de création d'un materiel pour le fournisseur dont l'id est présent dans l'url
     */
    #[Route('/fournisseur/profil/{id<\d+>}/createMateriel', name: 'app_fournisseur_profil_createMateriel')]
    public function createMateriel(Fournisseur $fournisseur, Request $request, ManagerRegistry $managerRegistry): Response
    {
        /*
         * vérification que c'est bien le bon fournisseur est connecté
         */
        $this->denyAccessUnlessGranted('ROLE_FOURNISSEUR');
        $user = $this->getUser();

        if (($user->getUserIdentifier() != $fournisseur->getUserIdentifier()) || 0 == $fournisseur->getVerif()) {

            return $this->redirectToRoute('app_fournisseur');
        }

        $entityManager = $managerRegistry->getManager();
        $typeMateriel = new TypeMateriel();
        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);
        $form->add('save', SubmitType::class, ['label' => 'Ajouter le materiel !']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeMateriel);
            $entityManager->flush();
            $fournisseur->addTypeMaterielPropose($typeMateriel);
            $entityManager->persist($fournisseur);
            $entityManager->flush();

            return $this->redirectToRoute('app_fournisseur_show', ['id' => $fournisseur->getId()]);
        }

        return $this->renderForm('fournisseur/form_service_materiel/createMateriel.html.twig', ['fournisseur' => $fournisseur, 'form' => $form]);
    }

    /*
     * Route menant à la page où il y a le formulaire de création d'un service pour le fournisseur dont l'id est présent dans l'url
     */
    #[Route('/fournisseur/profil/{id<\d+>}/createService', name: 'app_fournisseur_profil_createService')]
    public function createService(Fournisseur $fournisseur, Request $request, ManagerRegistry $managerRegistry): Response
    {
        /*
         * vérification que c'est bien le bon fournisseur est connecté
         */
        $this->denyAccessUnlessGranted('ROLE_FOURNISSEUR');
        $user = $this->getUser();

        if (($user->getUserIdentifier() != $fournisseur->getUserIdentifier()) || 0 == $fournisseur->getVerif()) {

            return $this->redirectToRoute('app_fournisseur');
        }

        $entityManager = $managerRegistry->getManager();
        $typeService = new TypeService();
        $form = $this->createForm(TypeServiceType::class, $typeService);
        $form->add('save', SubmitType::class, ['label' => 'Ajouter le materiel !']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeService);
            $entityManager->flush();
            $fournisseur->addTypeServicePropose($typeService);
            $entityManager->persist($fournisseur);
            $entityManager->flush();

            return $this->redirectToRoute('app_fournisseur_show', ['id' => $fournisseur->getId()]);
        }

        return $this->renderForm('fournisseur/form_service_materiel/createService.html.twig', ['fournisseur' => $fournisseur, 'form' => $form]);
    }
}
