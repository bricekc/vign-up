<?php

namespace App\Form;

use App\Entity\Reponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (!$options['questionnaire']->getThematiques()->isEmpty()) {
            foreach ($options['questionnaire']->getThematiques() as $thematique) {
                foreach ($thematique->getQuestions() as $question) {
                    $builder->add('question_'.$question->getId(), EntityType::class, [
                        'label' => $question->getIntituleQuestion(),
                        'class' => Reponse::class,
                        'label_attr' => ['class' => 'QuestionQuestionnaire'],
                        'choices' => $question->getReponses(),
                        'choice_label' => 'reponse',
                        'expanded' => true,
                    ]);
                }
            }
        } else {
            $questions = $options['questionnaire']->getQuestions();
            foreach ($questions as $question) {
                $builder->add('question_'.$question->getId(), EntityType::class, [
                    'label' => $question->getIntituleQuestion(),
                    'label_attr' => ['class' => 'QuestionQuestionnaire'],
                    'class' => Reponse::class,
                    'choices' => $question->getReponses(),
                    'choice_label' => 'reponse',
                    'expanded' => true,
                ]);
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'questionnaire' => null,
        ]);
        $resolver->setRequired('questionnaire');
    }
}
