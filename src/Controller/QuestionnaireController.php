<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Entity\Reponse;
use App\Entity\ResultatQuestionnaire;
use App\Entity\Viticulteur;
use App\Form\QuestionnaireType;
use App\Repository\QuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionnaireController extends AbstractController
{
    /**
     * @Route("/questionnaire", name="questionnaire")
     *
     * @param QuestionnaireRepository $questionnaireRepository
     *
     * @return Response
     *                  description : affiche la liste des questionnaires
     */
    #[Route('/questionnaire', name: 'app_questionnaire')]
    public function index(QuestionnaireRepository $repository): Response
    {
        $questionnaires = $repository->findAll();

        return $this->render('questionnaire/index.html.twig', ['questionnaires' => $questionnaires]);
    }

    /**
     * @Route("/questionnaire/{id}", name="questionnaire_show")
     *
     * @return Response
     *                  description : affiche le questionnaire en fonction de l'id. si l'utilisateur est connecté,
     *                  il peut répondre au questionnaire pour utilisateur connecté. si l'utilisateur n'est pas connecté,
     *                  il peut répondre au questionnaire pour utilisateur non connecté.
     */
    #[Route('/questionnaire/{id}', name: 'app_questionnaire_show')]
    public function questionnaireAction(Request $request, EntityManagerInterface $em, Questionnaire $questionnaire)
    {
        // On verifie si le questionnaire que le questionnaire n'est pas public
        if (!$questionnaire->isPublic()) {
            // Récupère le résultat du questionnaire pour l'utilisateur connecté
            $user = $this->getUser();
            if ($user instanceof Viticulteur) {
                $resultatQuestionnaire = $this->getDoctrine()->getRepository(ResultatQuestionnaire::class)->findOneBy([
                    'questionnaire' => $questionnaire,
                    'viticulteur' => $user,
                ]);

                // Si le résultat du questionnaire n'existe pas encore, on le crée
                if (!$resultatQuestionnaire) {
                    $resultatQuestionnaire = new ResultatQuestionnaire();
                    // On lie le résultat du questionnaire au questionnaire et à l'utilisateur connecté
                    $resultatQuestionnaire->setQuestionnaire($questionnaire);
                    $resultatQuestionnaire->setViticulteur($user);
                } else {
                    foreach ($resultatQuestionnaire->getReponses() as $reponse) {
                        $reponse->removeResultatQuestionnaire($resultatQuestionnaire);
                    }
                    $resultatQuestionnaire->getReponses()->clear();
                }

                // Création du formulaire à partir du ResultatQuestionnaire
                $form = $this->createForm(QuestionnaireType::class, null, ['questionnaire' => $questionnaire]);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    // On vide les réponses du résultat questionnaire avant de les remplir avec celles du formulaire
                    $resultatQuestionnaire->setReponses(new ArrayCollection());

                    // On récupère les données du formulaire
                    $data = $form->getData();
                    // On parcourt les données du formulaire et on récupère les réponses sélectionnées par l'utilisateur
                    $reponses = new ArrayCollection();

                    // Si la note existe deja on la remet à 0
                    if (null !== $resultatQuestionnaire->getNote()) {
                        $resultatQuestionnaire->setNote(0);
                    }
                    foreach ($data as $field => $value) {
                        if (str_starts_with($field, 'question_')) {
                            $reponseId = (int) str_replace('question_', '', $field);
                            $reponse = $value;
                            if ($reponse) {
                                if ($reponse->getnote()>1) {
                                    $resultatQuestionnaire->setNote($resultatQuestionnaire->getNote() + $reponse->getNote());
                                }
                                $question = $this->getDoctrine()->getRepository(Question::class)->findOneBy(['id' => $reponse->getQuestion()->getId()]);
                                if ($question) {
                                    $resultatQuestionnaire->addReponse($reponse);
                                }
                            }
                        }
                    }

                    $resultatQuestionnaire->setReponses($reponses);

                    // Si le formulaire a été soumis et est valide, on enregistre les réponses de l'utilisateur dans le résultat du questionnaire
                    $em->persist($resultatQuestionnaire);
                    $em->flush();

                    return $this->redirectToRoute('app_questionnaire_resultat', ['id' => $questionnaire->getId()]);
                }

                return $this->render('questionnaire/show.html.twig', [
                    'questionnaire' => $questionnaire,
                    'form' => $form->createView(),
                ]);
            }

            return $this->redirectToRoute('app_login');
        } else {
            // Création du formulaire à partir du questionnaire
            $form = $this->createForm(QuestionnaireType::class, null, ['questionnaire' => $questionnaire]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // On récupère les données du formulaire
                $data = $form->getData();
                // On parcourt les données du formulaire et on récupère les réponses sélectionnées par l'utilisateur
                $reponses = new ArrayCollection();
                $note = 0;
                foreach ($data as $field => $value) {
                    if ('question_' == substr($field, 0, 9)) {
                        $reponseId = (int) str_replace('question_', '', $field);
                        $reponse = $value;
                        if ($reponse) {
                            $note += $reponse->getNote();
                            $question = $this->getDoctrine()->getRepository(Question::class)->findOneBy(['id' => $reponse->getQuestion()->getId()]);
                            if ($question) {
                                $reponses->add($reponse);
                            }
                        }
                    }
                }
                if ($note < 4) {
                    $note = 4;
                }

                // On récupère l'objet de session
                $session = $request->getSession();

                // On enregistre la note et les réponses dans la session
                $session->set('note', $note);
                $session->set('reponses', $reponses);

                // On envoie la réponse
                return $this->render('questionnaire/resultat.html.twig', [
                    'questionnaire' => $questionnaire,
                ]);
            }

            return $this->render('questionnaire/show.html.twig', [
                'questionnaire' => $questionnaire,
                'form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/questionnaire/resultat/{id}", name="app_questionnaire_resultat")
     *
     * @param EntityManagerInterface $em
     * @param Questionnaire $questionnaire
     * @return Response
     *
     * description : Affiche le résultat du questionnaire
     */
    #[Route('/questionnaire/{id}/resultat', name: 'app_questionnaire_resultat')]
    public function questionnaireResultat(EntityManagerInterface $em, Questionnaire $questionnaire)
    {
        // Récupère le résultat du questionnaire pour l'utilisateur connecté
        $user = $this->getUser();
        if ($user instanceof Viticulteur) {
            $resultatQuestionnaire = $this->getDoctrine()->getRepository(ResultatQuestionnaire::class)->findOneBy([
                'questionnaire' => $questionnaire,
                'viticulteur' => $user,
            ]);

            // Si le résultat du questionnaire existe, on affiche la note et les réponses de l'utilisateur
            if ($resultatQuestionnaire) {
                // Récupère les questions du questionnaire
                $questions = $questionnaire->getQuestions();

                // Initialise un tableau qui va contenir les réponses de l'utilisateur pour chaque question
                $reponses = [];
                // Parcourt les questions du questionnaire
                foreach ($questions as $question) {
                    // Récupère la réponse de l'utilisateur pour cette question
                    $reponse = $resultatQuestionnaire->getReponses()->filter(function (Reponse $reponse) use ($question) {
                        return $reponse->getQuestion()->getId() === $question->getId();
                    })->first();
                    // Ajoute la réponse de l'utilisateur à la liste des réponses
                    $reponses[] = [
                        'question' => $question->getIntituleQuestion(),
                        'reponse' => $reponse ? $reponse->getReponse() : null,
                        'commentaire' => $reponse ? $reponse->getCommentaire() : null,
                    ];
                }

                // Calcule la note du questionnaire
                $note = $resultatQuestionnaire->getNote();

                $noteParThematique = [];
                foreach ($questionnaire->getThematiques() as $thematique) {
                    $noteParThematique[$thematique->getNomThematique()] = 0;
                }

                foreach ($resultatQuestionnaire->getReponses() as $reponse) {
                    $question = $reponse->getQuestion();
                    $thematiqueInt = $question->getThematique();
                    $noteParThematique[$thematiqueInt->getNomThematique()] += $reponse->getNote();
                }

                return $this->render('questionnaire/resultat.html.twig', [
                    'questionnaire' => $questionnaire,
                    'note' => $note,
                    'reponses' => $reponses,
                    'noteParThematique' => $noteParThematique,
                ]);
            }
        }

        throw $this->createNotFoundException('Le résultat du questionnaire n\'a pas été trouvé.');
    }
}
