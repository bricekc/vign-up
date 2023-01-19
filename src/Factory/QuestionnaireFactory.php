<?php

namespace App\Factory;

use App\Entity\Questionnaire;
use App\Repository\QuestionnaireRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Questionnaire>
 *
 * @method        Questionnaire|Proxy                     create(array|callable $attributes = [])
 * @method static Questionnaire|Proxy                     createOne(array $attributes = [])
 * @method static Questionnaire|Proxy                     find(object|array|mixed $criteria)
 * @method static Questionnaire|Proxy                     findOrCreate(array $attributes)
 * @method static Questionnaire|Proxy                     first(string $sortedField = 'id')
 * @method static Questionnaire|Proxy                     last(string $sortedField = 'id')
 * @method static Questionnaire|Proxy                     random(array $attributes = [])
 * @method static Questionnaire|Proxy                     randomOrCreate(array $attributes = [])
 * @method static QuestionnaireRepository|RepositoryProxy repository()
 * @method static Questionnaire[]|Proxy[]                 all()
 * @method static Questionnaire[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Questionnaire[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Questionnaire[]|Proxy[]                 findBy(array $attributes)
 * @method static Questionnaire[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Questionnaire[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class QuestionnaireFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'intitule_questionnaire' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Questionnaire $questionnaire): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Questionnaire::class;
    }
}
