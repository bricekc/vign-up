<?php

namespace App\Controller;

use App\Entity\Vigne;
use App\Entity\Viticulteur;
use App\Form\VigneType;
use App\Repository\VigneRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VigneController extends AbstractController
{
    #[Route('/profil/{id}/vigne', name: 'app_vigne', requirements: ['id' => '\d+'])]
    public function index(Viticulteur $viticulteur): Response
    {
        $vignes = $viticulteur->getVignes();

        return $this->render('vigne/index.html.twig', [
            'vignes' => $vignes,
            'viti' => $viticulteur,
            ]);
    }

    #[Route('/profil/{id}/vigne/create', name: 'app_vigne_create', requirements: ['id' => '\d+'])]
    public function create(Request $request, VigneRepository $repository, Viticulteur $viticulteur): Response
    {
        if ((!$this->getUser() || $this->getUser()->getId() !== $viticulteur->getId()) || 0 == $viticulteur->getVerif()) {
            return $this->redirectToRoute('app_home');
        }
        $vigne = new Vigne();
        $vigne->setViticulteur($viticulteur);
        $form = $this->createForm(VigneType::class, $vigne);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($vigne, true);

            return $this->redirectToRoute('app_vigne', ['id' => $vigne->getViticulteur()->getId()]);
        }

        return $this->renderForm('vigne/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/vigne/{id}/update', name: 'app_vigne_update', requirements: ['id' => '\d+'])]
    public function update(Request $request, Vigne $vigne, ManagerRegistry $managerRegistry): Response
    {
        $viticulteur = $vigne->getViticulteur();
        if (!$this->getUser() || $this->getUser()->getId() !== $viticulteur->getId()) {
            return $this->redirectToRoute('app_home');
        }
        $entityManager = $managerRegistry->getManager();
        $form = $this->createForm(VigneType::class, $vigne);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vigne', ['id' => $viticulteur->getId()]);
        }

        return $this->renderForm('vigne/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/vigne/{id}/delete', name: 'app_vigne_delete', requirements: ['id' => '\d+'])]
    public function delete(Request $request, Vigne $vigne, ManagerRegistry $managerRegistry): Response
    {
        $viticulteur = $vigne->getViticulteur();
        if ((!$this->getUser() || $this->getUser()->getId() !== $viticulteur->getId()) && (!in_array('ROLE_ADMIN', $this->getUser()->getRoles()))) {
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        $entityManager = $managerRegistry->getManager();
        if ($form->getClickedButton() && 'delete' === $form->getClickedButton()->getName()) {
            $entityManager->remove($vigne);
            $entityManager->flush();

            return $this->redirectToRoute('app_vigne', ['id' => $viticulteur->getId()]);
        }

        if ($form->getClickedButton() && 'cancel' === $form->getClickedButton()->getName()) {
            return $this->redirectToRoute('app_vigne', ['id' => $viticulteur->getId()]);
        }

        return $this->renderForm('vigne/delete.html.twig', [
            'form' => $form,
        ]);
    }
}
