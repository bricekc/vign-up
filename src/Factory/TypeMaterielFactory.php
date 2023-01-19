<?php

namespace App\Factory;

use App\Entity\TypeMateriel;
use App\Repository\TypeMaterielRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<TypeMateriel>
 *
 * @method        TypeMateriel|Proxy                     create(array|callable $attributes = [])
 * @method static TypeMateriel|Proxy                     createOne(array $attributes = [])
 * @method static TypeMateriel|Proxy                     find(object|array|mixed $criteria)
 * @method static TypeMateriel|Proxy                     findOrCreate(array $attributes)
 * @method static TypeMateriel|Proxy                     first(string $sortedField = 'id')
 * @method static TypeMateriel|Proxy                     last(string $sortedField = 'id')
 * @method static TypeMateriel|Proxy                     random(array $attributes = [])
 * @method static TypeMateriel|Proxy                     randomOrCreate(array $attributes = [])
 * @method static TypeMaterielRepository|RepositoryProxy repository()
 * @method static TypeMateriel[]|Proxy[]                 all()
 * @method static TypeMateriel[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static TypeMateriel[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static TypeMateriel[]|Proxy[]                 findBy(array $attributes)
 * @method static TypeMateriel[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static TypeMateriel[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class TypeMaterielFactory extends ModelFactory
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
            'description_materiel' => self::faker()->text(150),
            'intitule_materiel' => self::faker()->sentence(3),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(TypeMateriel $typeMateriel): void {})
        ;
    }

    protected static function getClass(): string
    {
        return TypeMateriel::class;
    }
}
