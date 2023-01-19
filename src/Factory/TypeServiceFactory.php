<?php

namespace App\Factory;

use App\Entity\TypeService;
use App\Repository\TypeServiceRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<TypeService>
 *
 * @method        TypeService|Proxy                     create(array|callable $attributes = [])
 * @method static TypeService|Proxy                     createOne(array $attributes = [])
 * @method static TypeService|Proxy                     find(object|array|mixed $criteria)
 * @method static TypeService|Proxy                     findOrCreate(array $attributes)
 * @method static TypeService|Proxy                     first(string $sortedField = 'id')
 * @method static TypeService|Proxy                     last(string $sortedField = 'id')
 * @method static TypeService|Proxy                     random(array $attributes = [])
 * @method static TypeService|Proxy                     randomOrCreate(array $attributes = [])
 * @method static TypeServiceRepository|RepositoryProxy repository()
 * @method static TypeService[]|Proxy[]                 all()
 * @method static TypeService[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static TypeService[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static TypeService[]|Proxy[]                 findBy(array $attributes)
 * @method static TypeService[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static TypeService[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class TypeServiceFactory extends ModelFactory
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
            'description_service' => self::faker()->text(150),
            'intitule_service' => self::faker()->sentence(3),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(TypeService $typeService): void {})
        ;
    }

    protected static function getClass(): string
    {
        return TypeService::class;
    }
}
