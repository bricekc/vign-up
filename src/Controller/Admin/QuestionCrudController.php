<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Thematique;
use App\Repository\ReponseRepository;
use App\Repository\ThematiqueRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('intitule_question'),
            CollectionField::new('reponses')
                ->setFormType(CollectionType::class)
                ->setFormTypeOptions([
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'class' => Reponse::class,
                        'choice_label' => 'reponse',
                        'query_builder' => function (ReponseRepository $repo) {
                            return $repo->createQueryBuilder('q')
                                ->orderBy('q.reponse', 'ASC');
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
