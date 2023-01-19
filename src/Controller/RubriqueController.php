<?php

namespace App\Controller;

use App\Entity\Rubrique;
use App\Form\FileUploadType;
use App\Repository\RubriqueRepository;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RubriqueController extends AbstractController
{
    /**
     * Cette fonction permet d'afficher la liste des rubriques.
     */
    #[Route('/rubrique', name: 'app_rubrique')]
    public function index(RubriqueRepository $repository, FileUploader $fileUploader): Response
    {
        // récupération de la liste des rubriques
        $extensions = [];
        $rubriques = $repository->findAll();
        $compteur = 0;
        foreach ($rubriques as $rubrique) {
            $name = '';
            $cond = true;
            for ($i = 0; $i < strlen($rubrique->getFilename()); ++$i) {
                if ('.' != $rubrique->getFilename()[-1 - $i] and $cond) {
                    $name .= $rubrique->getFilename()[-1 - $i];
                } else {
                    $cond = false;
                }
            }
            ++$compteur;
            $name = strrev($name);
            $extensions += [$compteur => $name];
        }
        // affichage de la vue avec tout les rubriques
        return $this->render('rubrique/index.html.twig', ['rubriques' => $rubriques, 'extensions' => $extensions]);
    }

    /**
     * Cette fonction de télécharger un fichier d'une rubrique.
     */
    #[Route('/download/{id}', name: 'app_rubrique_download')]
    public function downloadAction(Rubrique $rubrique)
    {
        // récupération du nom du fichier
        $filename = $rubrique->getFilename();
        // récupération du chemin du fichier avec le nom du fichier
        $filepath = 'web/files/'.$filename;

        // si le fichier existe
        if (file_exists($filepath)) {
            // préparation  des headers pour le téléchargement
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: '.filesize($filepath));
            readfile($filepath);
            exit;
        } else {
            // lance une erreur si le fichier n'existe pas
            return new Response('Le fichier demandé n\'existe pas', Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Cette fonction permet d'ajouter une nouvelle rubrique avec son fichier.
     */
    #[Route('/rubrique/upload', name: 'app_rubrique_upload')]
    public function CommunesAction(Request $request, FileUploader $file_uploader, RubriqueRepository $service)
    {
        // vérification que l'utilisateur est un admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // création d'un nouvel objet rubrique
        $rubrique = new Rubrique();
        // création du formulaire pour ajouter une rubrique
        $form = $this->createForm(FileUploadType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // récupération du fichier
            $file = $form['upload_file']->getData();
            // récupération de la liste des rubriques
            $rubriques = $service->findAll();
            if ($file) {
                $condition = true;
                // vérification que le fichier n'existe pas déjà dans la base de données
                foreach ($rubriques as $rubriqu) {
                    if ($rubriqu->getFilename() == $file_uploader->name($file)) {
                        $condition = false;
                    }
                }
                // si le fichier n'existe pas déjà dans la base de données
                if ($condition) {
                    if ($form['video']->getData()) {
                        $videoLink = $form['video']->getData();
                        if (preg_match('/<iframe[^>]+src="(https:\/\/www.youtube.com\/[^"]+)[^>]*>/', $videoLink)) {
                            $rubrique->setVideoLink($videoLink);
                        } else {
                            // L'iframe n'est pas sûre, on ne l'utilise pas
                            return $this->redirectToRoute('app_rubrique', ['rubriques' => $rubriques]);
                        }
                    }
                    // upload du fichier
                    $file_name = $file_uploader->upload($file);
                    $rubrique->setFilename($file_name);
                    $rubrique->setTitre($form['titre']->getData());
                    $rubrique->setDescription($form['description']->getData());
                    $rubrique->setAuteur($form['auteur']->getData());
                    // enregistrement de la rubrique dans la base de données
                    $service->save($rubrique, true);
                }
            } else {
                // on verifie que ce qui est fournit est bien un iframe venant de youtube, sinon on ne fait rien !
                if ($form['video']->getData()) {
                    $videoLink = $form['video']->getData();
                    if (preg_match('/<iframe[^>]+src="(https:\/\/www.youtube.com\/[^"]+)[^>]*>/', $videoLink)) {
                        $rubrique->setVideoLink($videoLink);
                    } else {
                        // L'iframe n'est pas sûre, on ne l'utilise pas
                        return $this->redirectToRoute('app_rubrique', ['rubriques' => $rubriques]);
                    }
                }
                $rubrique->setTitre($form['titre']->getData());
                $rubrique->setDescription($form['description']->getData());
                $rubrique->setAuteur($form['auteur']->getData());
                // enregistrement de la rubrique dans la base de données
                // enregistrement de la rubrique dans la base de données
                $service->save($rubrique, true);
            }
            // redirection vers la liste des rubriques
            return $this->redirectToRoute('app_rubrique', ['rubriques' => $rubriques]);
        }

        // affichage de la vue pour l'upload de fichier
        return $this->render('rubrique/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Cette fonction permet de supprimer une rubrique et son fichier.
     */
    #[Route('/rubrique/delete/{id}', name: 'app_rubrique_delete')]
    public function deleteAction(Rubrique $rubrique, RubriqueRepository $service, ManagerRegistry $doctrine)
    {
        // vérification que l'utilisateur est un admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $doctrine->getManager();
        // récupération du nom du fichier
        if ($rubrique->getFilename()) {
            $filename = $rubrique->getFilename();
            // récupération du chemin avec le nom du fichier
            $filepath = 'web/files/'.$filename;
            // suppression du fichier qui est stocké sur le serveur
            unlink($filepath);
        }
        // suppression de la rubrique dans la base de données
        $entityManager->remove($rubrique);
        $entityManager->flush();
        // récupéraiton de la nouvelle liste de rubrique
        $rubriques = $service->findAll();

        // redirection vers la page de la liste des rubriques
        return $this->redirectToRoute('app_rubrique', ['rubriques' => $rubriques]);
    }
}
