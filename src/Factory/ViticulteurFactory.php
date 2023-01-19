<?php

namespace App\Factory;

use App\Entity\Viticulteur;
use App\Repository\ViticulteurRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Viticulteur>
 *
 * @method        Viticulteur|Proxy                     create(array|callable $attributes = [])
 * @method static Viticulteur|Proxy                     createOne(array $attributes = [])
 * @method static Viticulteur|Proxy                     find(object|array|mixed $criteria)
 * @method static Viticulteur|Proxy                     findOrCreate(array $attributes)
 * @method static Viticulteur|Proxy                     first(string $sortedField = 'id')
 * @method static Viticulteur|Proxy                     last(string $sortedField = 'id')
 * @method static Viticulteur|Proxy                     random(array $attributes = [])
 * @method static Viticulteur|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ViticulteurRepository|RepositoryProxy repository()
 * @method static Viticulteur[]|Proxy[]                 all()
 * @method static Viticulteur[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Viticulteur[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Viticulteur[]|Proxy[]                 findBy(array $attributes)
 * @method static Viticulteur[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Viticulteur[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ViticulteurFactory extends UserFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct($userPasswordHasher);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return array_merge(parent::getDefaults(), [
            'num_siret' => self::faker()->numerify('##############'),
            'verif' => false,
        ]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        /** @var ViticulteurFactory $self */
        $self = parent::initialize();

        return $self;
    }

    protected static function getClass(): string
    {
        return Viticulteur::class;
    }
}
