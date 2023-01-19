<?php

namespace App\Factory;

use App\Entity\Vigne;
use App\Repository\VigneRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Vigne>
 *
 * @method        Vigne|Proxy create(array|callable $attributes = [])
 * @method static Vigne|Proxy createOne(array $attributes = [])
 * @method static Vigne|Proxy find(object|array|mixed $criteria)
 * @method static Vigne|Proxy findOrCreate(array $attributes)
 * @method static Vigne|Proxy first(string $sortedField = 'id')
 * @method static Vigne|Proxy last(string $sortedField = 'id')
 * @method static Vigne|Proxy random(array $attributes = [])
 * @method static Vigne|Proxy randomOrCreate(array $attributes = [])
 * @method static VigneRepository|RepositoryProxy repository()
 * @method static Vigne[]|Proxy[] all()
 * @method static Vigne[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Vigne[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Vigne[]|Proxy[] findBy(array $attributes)
 * @method static Vigne[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Vigne[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class VigneFactory extends ModelFactory
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
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Vigne $vigne): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Vigne::class;
    }
}
