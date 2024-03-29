<?php

namespace App\Factory;

use App\Entity\Main\SymfonyGroup;
use App\Repository\GroupsRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<SymfonyGroup>
 *
 * @method static SymfonyGroup|Proxy createOne(array $attributes = [])
 * @method static SymfonyGroup[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static SymfonyGroup|Proxy find(object|array|mixed $criteria)
 * @method static SymfonyGroup|Proxy findOrCreate(array $attributes)
 * @method static SymfonyGroup|Proxy first(string $sortedField = 'id')
 * @method static SymfonyGroup|Proxy last(string $sortedField = 'id')
 * @method static SymfonyGroup|Proxy random(array $attributes = [])
 * @method static SymfonyGroup|Proxy randomOrCreate(array $attributes = [])
 * @method static SymfonyGroup[]|Proxy[] all()
 * @method static SymfonyGroup[]|Proxy[] findBy(array $attributes)
 * @method static SymfonyGroup[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static SymfonyGroup[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static GroupsRepository|RepositoryProxy repository()
 * @method SymfonyGroup|Proxy create(array|callable $attributes = [])
 */
final class SymfonyGroupFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->text(20),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(SymfonyGroup $symfonyGroup): void {})
        ;
    }

    protected static function getClass(): string
    {
        return SymfonyGroup::class;
    }
}
