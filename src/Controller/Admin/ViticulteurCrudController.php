<?php

namespace App\Controller\Admin;

use App\Entity\Viticulteur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ViticulteurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Viticulteur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email')->hideOnForm(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('num_siret'),
            BooleanField::new('verif'),
        ];
    }
}
