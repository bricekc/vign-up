<?php

namespace App\DataFixtures;

use App\Factory\QuestionFactory;
use App\Factory\QuestionnaireFactory;
use App\Factory\ThematiqueFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        QuestionFactory::createSequence([
            ['intitule_question' => 'Quelle est la surface de la parcelle ?',
                'thematique' => ThematiqueFactory::find(1)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(),  ],
            ['intitule_question' => 'Quelle le niveau de dévers sur la parcelle (dans le sens de plantation) ?',
                'thematique' => ThematiqueFactory::find(1)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(),  ],
            ['intitule_question' => 'Quelle est la dimension des tournières?',
                'thematique' => ThematiqueFactory::find(1)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(),  ],
            ['intitule_question' => 'La parcelle est-elle enclavée ?',
                'thematique' => ThematiqueFactory::find(1)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(),  ],
            ['intitule_question' => 'Quel est l’âge de la parcelle ?',
                'thematique' => ThematiqueFactory::find(2)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(), ],
            ['intitule_question' => 'Morcèlement du parcellaire',
                'thematique' => ThematiqueFactory::find(3)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(), ],
            ['intitule_question' => 'Dans les 5 ans, quelle surface souhaiteriez-vous convertir en VSL ?',
                'thematique' => ThematiqueFactory::find(3)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(), ],
            ['intitule_question' => 'La structure exploitante est-elle propriétaire des vignes à convertir ?',
                'thematique' => ThematiqueFactory::find(3)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(), ],
            ['intitule_question' => 'Avis de l’exploitant sur la conversion en VSL',
                'thematique' => ThematiqueFactory::find(4)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(), ],
            ['intitule_question' => 'Avis des associés et salariés sur la conversion en VSL',
                'thematique' => ThematiqueFactory::find(4)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(), ],
            ['intitule_question' => 'Avis du propriétaire sur la conversion en VSL',
                'thematique' => ThematiqueFactory::find(4)->object(),
                'questionnaire' => QuestionnaireFactory::find(2)->object(), ],
            ['intitule_question' => 'Quelle est la surface de la parcelle ?',
                'questionnaire' => QuestionnaireFactory::find(1)->object(), ],
            ['intitule_question' => 'La parcelle présente-t-elle un dévers, des pentes fortes ou une configuration difficile d’accès ?',
                'questionnaire' => QuestionnaireFactory::find(1)->object(), ],
            ['intitule_question' => 'Pouvez-vous absorber une perte de rendement de 15 à 20% sur cette parcelle (par rapport à son plein potentiel en plantation étroite) ?',
                'questionnaire' => QuestionnaireFactory::find(1)->object(), ],
            ['intitule_question' => 'Les différentes parties prenantes (exploitants, propriétaires, salariés) sont-t-ils favorables à l’implantation de vignes semi-larges ?',
                'questionnaire' => QuestionnaireFactory::find(1)->object(), ],
        ]);
    }

    public function getDependencies(): array
    {
        return [
            QuestionnaireFixtures::class,
            ThematiqueFixtures::class,
        ];
    }
}
