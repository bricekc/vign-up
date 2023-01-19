<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Commentaire;
use App\Entity\Fournisseur;
use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Entity\Reponse;
use App\Entity\Tag;
use App\Entity\Thematique;
use App\Entity\Viticulteur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle("Vign'UP");
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Tags des materiels et services', 'fas fa-tags', Tag::class);
        yield MenuItem::linkToCrud('Viticulteur', 'fas fa-user', Viticulteur::class);
        yield MenuItem::linkToCrud('Fournisseur', 'fas fa-user', Fournisseur::class);
        yield MenuItem::linkToCrud('Administrateur', 'fas fa-user', Admin::class);
        yield MenuItem::subMenu('Questionnaire', 'fa-solid fa-clipboard-question')->setSubItems([
            MenuItem::linkToCrud('Commentaire', 'fa-solid fa-comments', Commentaire::class),
            MenuItem::linkToCrud('Reponse', 'fa-solid fa-square-check', Reponse::class),
            MenuItem::linkToCrud('Question', 'fas fa-question', Question::class),
            MenuItem::linkToCrud('Thematique', 'fa-solid fa-flag', Thematique::class),
            MenuItem::linkToCrud('Questionnaire', 'fa-solid fa-clipboard-question', Questionnaire::class),
        ]);
        yield MenuItem::linkToUrl('Quitter le dashboard', 'fa fa-sign-out', '/');
    }
}
