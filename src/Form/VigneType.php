<?php

namespace App\Form;

use App\Entity\Vigne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VigneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('latitude', TextType::class, [
                'empty_data' => '',
                'required' => true])
            ->add('longitude', TextType::class, [
                'empty_data' => '',
                'required' => true])
            ->add('superficie', NumberType::class, [
                'empty_data' => '',
                'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vigne::class,
        ]);
    }
}
