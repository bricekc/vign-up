<?php

namespace App\DataFixtures;

use App\Factory\CommentaireFactory;
use App\Factory\QuestionFactory;
use App\Factory\ReponseFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;


class ReponseFixtures extends Fixture implements DependentFixtureInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        $commentaire1 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'La taille de la parcelle rend délicate l’implantation de vignes semi-larges.']);
        $commentaire2 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'La taille de la parcelle est favorable à l’implantation de vignes semi-larges.']);
        $commentaire3 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'Le niveau de dévers indiqué n’est pas contraignant pour l’utilisation du matériel tracté.']);
        $commentaire4 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'Le niveau de dévers indiqué peut s’avérer contraignant pour l’utilisation de matériel tracté.']);
        $commentaire5 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'Attention, le niveau de dévers indiqué proscrit l’utilisation de matériel tracté.']);
        $commentaire6 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'Attention, la dimension des tournières proscrit l’utilisation de matériel tracté']);
        $commentaire7 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'L’utilisation de matériel tracté peut être délicate en raison de la largeur des tournières.']);
        $commentaire8 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'la dimension des tournières est idéale pour tous les travaux en tracteur interligne']);
        $commentaire9 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'L’enclavement de la parcelle rend impossible l’utilisation d’un tracteur vigneron.']);
        $commentaire10 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'L’accessibilité de la parcelle rend possible l’utilisation du tracteur vigneron']);
        $commentaire11 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'il est préférable de privilégier le partage de matériel : copropriété, Cuma, prestation, entraide.']);
        $commentaire12 = (new \App\Factory\CommentaireFactory)->create(['commentaire' => 'un investissement individuel dans du matériel adapté est envisageable.']);

        ReponseFactory::createSequence([
            ['reponse' => 'Inférieure à 20 ares ?', 'note' => 1,
                'question' => QuestionFactory::find(1)->object(),
                'commentaire' => $commentaire1,],
            ['reponse' => 'Supérieure à 20 ares ?', 'note' => 2,
                'question' => QuestionFactory::find(1)->object(),
                'commentaire' => $commentaire2,],
            ['reponse' => '<5%', 'note' => 3,
                'question' => QuestionFactory::find(2)->object(),
                'commentaire' => $commentaire3,],
            ['reponse' => 'Entre 5 et 9 %', 'note' => 2,
                'question' => QuestionFactory::find(2)->object(),
                'commentaire' => $commentaire4,],
            ['reponse' => '10% ou plus', 'note' => 1,
                'question' => QuestionFactory::find(2)->object(),
                'commentaire' => $commentaire5,],
            ['reponse' => 'Moins de 5 mètres', 'note' => 1,
                'question' => QuestionFactory::find(3)->object(),
                'commentaire' => $commentaire6,],
            ['reponse' => 'Entre 5 et 7 mètres', 'note' => 2,
                'question' => QuestionFactory::find(3)->object(),
                'commentaire' => $commentaire7,],
            ['reponse' => 'Plus de 7 mètres', 'note' => 3,
                'question' => QuestionFactory::find(3)->object(),
                'commentaire' => $commentaire8,],
            ['reponse' => 'Oui la parcelle est entourée par 4 autres parcelles sans chemin les séparant', 'note' => 1,
                'question' => QuestionFactory::find(4)->object(),
                'commentaire' => $commentaire9,],
            ['reponse' => 'Non la parcelle est accessible via une route ou un chemin', 'note' => 2,
                'question' => QuestionFactory::find(4)->object(),
                'commentaire' => $commentaire10,],
            ['reponse' => 'Moins de 10 ans', 'note' => 1,
                'question' => QuestionFactory::find(5)->object(), ],
            ['reponse' => 'Entre 10 et 30 ans', 'note' => 2,
                'question' => QuestionFactory::find(5)->object(), ],
            ['reponse' => '+ de 30 ans', 'note' => 3,
                'question' => QuestionFactory::find(5)->object(), ],
            ['reponse' => '1/3 des parcelles ont une surface supérieure à 20 ares', 'note' => 1,
                'question' => QuestionFactory::find(6)->object(), ],
            ['reponse' => 'Entre 1 et 2/3 des parcelles ont une surface supérieure à 20 ares', 'note' => 2,
                'question' => QuestionFactory::find(6)->object(), ],
            ['reponse' => 'Plus de 2/3 des parcelles ont une surface supérieure à 20 ares​', 'note' => 3,
                'question' => QuestionFactory::find(6)->object(), ],
            ['reponse' => '- De 2 hectares', 'note' => 0,
                'question' => QuestionFactory::find(7)->object(),
                'commentaire' => $commentaire11,],
            ['reponse' => '+ de 2 hectares', 'note' => 0,
                'question' => QuestionFactory::find(7)->object(),
                'commentaire' => $commentaire12,],
            ['reponse' => 'Oui', 'note' => 2,
                'question' => QuestionFactory::find(8)->object(), ],
            ['reponse' => 'non', 'note' => 1,
                'question' => QuestionFactory::find(8)->object(), ],
            ['reponse' => 'Défavorable', 'note' => 1,
                'question' => QuestionFactory::find(9)->object(), ],
            ['reponse' => 'Indifférent', 'note' => 2,
                'question' => QuestionFactory::find(9)->object(), ],
            ['reponse' => 'Favorable', 'note' => 3,
                'question' => QuestionFactory::find(9)->object(), ],
            ['reponse' => 'Défavorable', 'note' => 1,
                'question' => QuestionFactory::find(10)->object(), ],
            ['reponse' => 'Indifférent', 'note' => 2,
                'question' => QuestionFactory::find(10)->object(), ],
            ['reponse' => 'Favorable', 'note' => 3,
                'question' => QuestionFactory::find(10)->object(), ],
            ['reponse' => 'Défavorable', 'note' => 1,
                'question' => QuestionFactory::find(11)->object(), ],
            ['reponse' => 'Indifférent', 'note' => 2,
                'question' => QuestionFactory::find(11)->object(), ],
            ['reponse' => 'Favorable', 'note' => 3,
                'question' => QuestionFactory::find(11)->object(), ],
            ['reponse' => 'Inférieure à 20 ares ?', 'note' => 1,
                'question' => QuestionFactory::find(12)->object(), ],
            ['reponse' => 'Supérieure à 20 ares ?', 'note' => 2,
                'question' => QuestionFactory::find(12)->object(), ],
            ['reponse' => 'Plûtot oui ?', 'note' => 1,
                'question' => QuestionFactory::find(13)->object(), ],
            ['reponse' => 'Plûtot non ?', 'note' => 2,
                'question' => QuestionFactory::find(13)->object(), ],
            ['reponse' => 'non', 'note' => -1000,
                'question' => QuestionFactory::find(14)->object(), ],
            ['reponse' => 'oui', 'note' => 2,
                'question' => QuestionFactory::find(14)->object(), ],
            ['reponse' => 'plutôt défavorables', 'note' => 1,
                'question' => QuestionFactory::find(15)->object(), ],
            ['reponse' => 'plutôt favorables', 'note' => 2,
                'question' => QuestionFactory::find(15)->object(), ],
        ]);
        $this->entityManager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuestionFixtures::class,
            CommentaireFixtures::class,
        ];
    }
}
