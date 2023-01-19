<?php

namespace App\Factory;

use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Fournisseur>
 *
 * @method        Fournisseur|Proxy                     create(array|callable $attributes = [])
 * @method static Fournisseur|Proxy                     createOne(array $attributes = [])
 * @method static Fournisseur|Proxy                     find(object|array|mixed $criteria)
 * @method static Fournisseur|Proxy                     findOrCreate(array $attributes)
 * @method static Fournisseur|Proxy                     first(string $sortedField = 'id')
 * @method static Fournisseur|Proxy                     last(string $sortedField = 'id')
 * @method static Fournisseur|Proxy                     random(array $attributes = [])
 * @method static Fournisseur|Proxy                     randomOrCreate(array $attributes = [])
 * @method static FournisseurRepository|RepositoryProxy repository()
 * @method static Fournisseur[]|Proxy[]                 all()
 * @method static Fournisseur[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Fournisseur[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Fournisseur[]|Proxy[]                 findBy(array $attributes)
 * @method static Fournisseur[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Fournisseur[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class FournisseurFactory extends UserFactory
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
            'verif' => true,
        ]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        /** @var FournisseurFactory $self */
        $self = parent::initialize();

        return $self;
    }

    protected static function getClass(): string
    {
        return Fournisseur::class;
    }
}
