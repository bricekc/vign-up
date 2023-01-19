<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use App\Entity\Reponse;
use App\Repository\CommentaireRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReponseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reponse::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('reponse'),
            IntegerField::new('note'),
            TextField::new('commentaire')
                ->setFormType(EntityType::class)
                ->setFormTypeOptions([
                    'class' => Commentaire::class,
                    'choice_label' => 'commentaire',
                    'query_builder' => function (CommentaireRepository $repo) {
                        return $repo->createQueryBuilder('q')
                            ->orderBy('q.commentaire', 'ASC');
                    },
                ]),
        ];
    }
}
