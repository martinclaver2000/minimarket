<?php

namespace App\Factory;

use App\Entity\Ad;
use App\Enum\AdStatusEnum;
use Symfony\Component\String\Slugger\SluggerInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Ad>
 */
final class AdFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public static function class(): string
    {
        return Ad::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'account' => AccountFactory::new(),
            'adStatus' => self::faker()->randomElement(AdStatusEnum::cases()),
            'address' => self::faker()->address(),
            'description' => self::faker()->text(),
            'messageContactCount' => self::faker()->numberBetween(),
            'price' => self::faker()->text(255),
            'title' => self::faker()->words(6, true),
            'viewsCount' => self::faker()->numberBetween(),
            'whatsappContactCount' => self::faker()->numberBetween(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (Ad $ad): void {
                $ad->setSlug($this->slugger->slug($ad->getTitle().' '.uniqid(), '_'));
            });
    }
}
