<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\TypeService;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description_service', TextType::class, [
                'empty_data' => '',
                'required' => true])
            ->add('intitule_service', TextType::class, [
                'empty_data' => '',
                'required' => true])
            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('t')
                        ->orderBy('t.nom', 'ASC');
                },
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeService::class,
        ]);
    }
}
