<?php

namespace App\Factory;

use App\Entity\SAV;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<SAV>
 */
class SAVFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return SAV::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'code' => self::faker()->text(10),
            'createdDate' => self::faker()->dateTime(),
            'representative' => self::faker()->text(100),
            'breakdown' => self::faker()->text(255),
            'endDate' => self::faker()->dateTime(),
            'repairedBy' => self::faker()->text(100),
            'repairs' => self::faker()->text(255),
            'comments' => self::faker()->text(255),
            'charge' => self::faker()->text(255),
            'spreadsheetName' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(SAV $sav): void {})
        ;
    }
}
