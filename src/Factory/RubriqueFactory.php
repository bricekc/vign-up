<?php

namespace App\Factory;

use App\Entity\Rubrique;
use App\Repository\RubriqueRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Rubrique>
 *
 * @method        Rubrique|Proxy                     create(array|callable $attributes = [])
 * @method static Rubrique|Proxy                     createOne(array $attributes = [])
 * @method static Rubrique|Proxy                     find(object|array|mixed $criteria)
 * @method static Rubrique|Proxy                     findOrCreate(array $attributes)
 * @method static Rubrique|Proxy                     first(string $sortedField = 'id')
 * @method static Rubrique|Proxy                     last(string $sortedField = 'id')
 * @method static Rubrique|Proxy                     random(array $attributes = [])
 * @method static Rubrique|Proxy                     randomOrCreate(array $attributes = [])
 * @method static RubriqueRepository|RepositoryProxy repository()
 * @method static Rubrique[]|Proxy[]                 all()
 * @method static Rubrique[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Rubrique[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Rubrique[]|Proxy[]                 findBy(array $attributes)
 * @method static Rubrique[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Rubrique[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class RubriqueFactory extends ModelFactory
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
            'titre' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Rubrique $rubrique): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Rubrique::class;
    }
}
