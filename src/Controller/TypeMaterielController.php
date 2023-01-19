<?php

namespace App\Controller;

use App\Entity\TypeMateriel;
use App\Form\TypeMaterielType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeMaterielController extends AbstractController
{
    #[Route('/typeMateriel/{id<\d+>}/update', name: 'app_type_materiel_update')]
    public function update(TypeMateriel $materiel, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $this->denyAccessUnlessGranted('ROLE_FOURNISSEUR');
        $fournisseurs = $materiel->getFournisseurs();
        $user = $this->getUser();
        $verif = false;
        foreach ($fournisseurs as $fournisseur) {
            if ($user->getId() == $fournisseur->getId()) {
                $verif = true;
            }
        }
        if (!$verif) {
            return $this->redirectToRoute('app_fournisseur');
        }

        $entityManager = $managerRegistry->getManager();
        $form = $this->createForm(TypeMaterielType::class, $materiel);
        $form->add('save', SubmitType::class, ['label' => 'Valider les modifications']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_fournisseur_show', ['id' => $fournisseur->getId()]);
        }

        return $this->renderForm('type_materiel/updateMateriel.html.twig', [
            'typemateriel' => $materiel,
            'form' => $form,
        ]);
    }

    #[Route('/typeMateriel/{id<\d+>}/delete', name: 'app_type_materiel_delete')]
    public function delete(TypeMateriel $materiel, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $this->denyAccessUnlessGranted('ROLE_FOURNISSEUR');
        $fournisseurs = $materiel->getFournisseurs();
        $user = $this->getUser();
        $verif = false;
        foreach ($fournisseurs as $fournisseur) {
            if ($user->getId() == $fournisseur->getId()) {
                $verif = true;
            }
        }
        if (!$verif) {
            return $this->redirectToRoute('app_fournisseur');
        }

        $entityManager = $managerRegistry->getManager();
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ('delete' === $form->getClickedButton()->getName()) {
                $entityManager->remove($materiel);
                $entityManager->flush();

                return $this->redirectToRoute('app_fournisseur_show', ['id' => $fournisseur->getId()]);
            } elseif ('cancel' === $form->getClickedButton()->getName()) {
                return $this->redirectToRoute('app_fournisseur_show', ['id' => $fournisseur->getId()]);
            }
        }

        return $this->renderForm('type_materiel/deleteMateriel.html.twig', [
            'typemateriel' => $materiel,
            'form' => $form,
        ]);
    }
}
