<?php

namespace App\Factory;

use App\Entity\Thematique;
use App\Repository\ThematiqueRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Thematique>
 *
 * @method        Thematique|Proxy create(array|callable $attributes = [])
 * @method static Thematique|Proxy createOne(array $attributes = [])
 * @method static Thematique|Proxy find(object|array|mixed $criteria)
 * @method static Thematique|Proxy findOrCreate(array $attributes)
 * @method static Thematique|Proxy first(string $sortedField = 'id')
 * @method static Thematique|Proxy last(string $sortedField = 'id')
 * @method static Thematique|Proxy random(array $attributes = [])
 * @method static Thematique|Proxy randomOrCreate(array $attributes = [])
 * @method static ThematiqueRepository|RepositoryProxy repository()
 * @method static Thematique[]|Proxy[] all()
 * @method static Thematique[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Thematique[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Thematique[]|Proxy[] findBy(array $attributes)
 * @method static Thematique[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Thematique[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ThematiqueFactory extends ModelFactory
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
            'NomThematique' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Thematique $thematique): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Thematique::class;
    }
}
