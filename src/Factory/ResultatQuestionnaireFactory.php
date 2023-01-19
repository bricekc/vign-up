<?php

namespace App\Factory;

use App\Entity\ResultatQuestionnaire;
use App\Repository\ResultatQuestionnaireRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ResultatQuestionnaire>
 *
 * @method        ResultatQuestionnaire|Proxy                     create(array|callable $attributes = [])
 * @method static ResultatQuestionnaire|Proxy                     createOne(array $attributes = [])
 * @method static ResultatQuestionnaire|Proxy                     find(object|array|mixed $criteria)
 * @method static ResultatQuestionnaire|Proxy                     findOrCreate(array $attributes)
 * @method static ResultatQuestionnaire|Proxy                     first(string $sortedField = 'id')
 * @method static ResultatQuestionnaire|Proxy                     last(string $sortedField = 'id')
 * @method static ResultatQuestionnaire|Proxy                     random(array $attributes = [])
 * @method static ResultatQuestionnaire|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ResultatQuestionnaireRepository|RepositoryProxy repository()
 * @method static ResultatQuestionnaire[]|Proxy[]                 all()
 * @method static ResultatQuestionnaire[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static ResultatQuestionnaire[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static ResultatQuestionnaire[]|Proxy[]                 findBy(array $attributes)
 * @method static ResultatQuestionnaire[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static ResultatQuestionnaire[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ResultatQuestionnaireFactory extends ModelFactory
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
            'note' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(ResultatQuestionnaire $resultatQuestionnaire): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ResultatQuestionnaire::class;
    }
}
