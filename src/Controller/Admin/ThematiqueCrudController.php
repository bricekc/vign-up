<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use App\Entity\Question;
use App\Entity\Thematique;
use App\Repository\CommentaireRepository;
use App\Repository\QuestionRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ThematiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Thematique::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('NomThematique'),
            CollectionField::new('questions')
                ->setFormType(CollectionType::class)
                ->setFormTypeOptions([
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'class' => Question::class,
                        'choice_label' => 'intitule_question',
                        'query_builder' => function (QuestionRepository $repo) {
                            return $repo->createQueryBuilder('q')
                                ->orderBy('q.intitule_question', 'ASC');
                        },
                    ],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'delete_empty' => true,
                ]),
            CollectionField::new('commentaires')
                ->setFormType(CollectionType::class)
                ->setFormTypeOptions([
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'class' => Commentaire::class,
                        'choice_label' => 'commentaire',
                        'query_builder' => function (CommentaireRepository $repo) {
                            return $repo->createQueryBuilder('q')
                                ->orderBy('q.commentaire', 'ASC');
                        },
                    ],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'delete_empty' => true,
                ]),
        ];
    }
}
