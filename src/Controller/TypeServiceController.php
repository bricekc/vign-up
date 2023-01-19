<?php

namespace App\Controller;

use App\Entity\TypeService;
use App\Form\TypeServiceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeServiceController extends AbstractController
{
    #[Route('/typeService/{id<\d+>}/update', name: 'app_type_service_update')]
    public function update(TypeService $service, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $this->denyAccessUnlessGranted('ROLE_FOURNISSEUR');
        $fournisseurs = $service->getFournisseurs();
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
        $form = $this->createForm(TypeServiceType::class, $service);
        $form->add('save', SubmitType::class, ['label' => 'Valider les modifications']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_fournisseur_show', ['id' => $fournisseur->getId()]);
        }

        return $this->renderForm('type_service/updateService.html.twig', [
            'typeservice' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/typeService/{id<\d+>}/delete', name: 'app_type_service_delete')]
    public function delete(TypeService $service, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $this->denyAccessUnlessGranted('ROLE_FOURNISSEUR');
        $fournisseurs = $service->getFournisseurs();
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
                $entityManager->remove($service);
                $entityManager->flush();

                return $this->redirectToRoute('app_fournisseur_show', ['id' => $fournisseur->getId()]);
            } elseif ('cancel' === $form->getClickedButton()->getName()) {
                return $this->redirectToRoute('app_fournisseur_show', ['id' => $fournisseur->getId()]);
            }
        }

        return $this->renderForm('type_service/deleteService.html.twig', [
            'typeservice' => $service,
            'form' => $form,
        ]);
    }
}
