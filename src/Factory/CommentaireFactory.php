<?php

namespace App\Factory;

use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Commentaire>
 *
 * @method        Commentaire|Proxy                     create(array|callable $attributes = [])
 * @method static Commentaire|Proxy                     createOne(array $attributes = [])
 * @method static Commentaire|Proxy                     find(object|array|mixed $criteria)
 * @method static Commentaire|Proxy                     findOrCreate(array $attributes)
 * @method static Commentaire|Proxy                     first(string $sortedField = 'id')
 * @method static Commentaire|Proxy                     last(string $sortedField = 'id')
 * @method static Commentaire|Proxy                     random(array $attributes = [])
 * @method static Commentaire|Proxy                     randomOrCreate(array $attributes = [])
 * @method static CommentaireRepository|RepositoryProxy repository()
 * @method static Commentaire[]|Proxy[]                 all()
 * @method static Commentaire[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Commentaire[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Commentaire[]|Proxy[]                 findBy(array $attributes)
 * @method static Commentaire[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Commentaire[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class CommentaireFactory extends ModelFactory
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
            'commentaire' => self::faker()->text(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Commentaire $commentaire): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Commentaire::class;
    }
}
