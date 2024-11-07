<?php

namespace App\Factory;

use App\Entity\Ad;
use App\Entity\Category;
use App\Enum\AdStatusEnum;
use App\Repository\CategoryRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Ad>
 */
final class AdFactory extends PersistentProxyObjectFactory
{
    private const PHONES = ['iPhone 14 Pro Max', 'iPhone 13 Mini', 'iPhone SE (2023)', 'Samsung Galaxy S24 Ultra', 'Samsung Galaxy Z Flip 5', 'Samsung Galaxy A54', 'Samsung Galaxy S23 FE', 'Motorola Razr 2024', 'Motorola Edge 40 Pro', 'Motorola Moto G Power 5G', 'Motorola Edge Plus 2023', 'Google Pixel 8 Pro', 'Google Pixel 7a', 'Google Pixel Fold', 'Google Pixel 6', 'OnePlus 11 Pro', 'OnePlus Nord CE 3 Lite', 'OnePlus 10T', 'OnePlus 9 Pro', 'Xiaomi 13 Ultra', 'Xiaomi Redmi Note 12 Pro', 'Xiaomi Mi Mix Fold 3', 'Xiaomi Poco X5', 'Huawei P60 Pro', 'Huawei Mate X3', 'Huawei Nova 11 Pro', 'Huawei Y9a', 'Oppo Find X6 Pro', 'Oppo Reno 10 Pro', 'Oppo A98 5G', 'Oppo K10', 'Sony Xperia 1 V', 'Sony Xperia 5 IV', 'Sony Xperia 10 III', 'Sony Xperia Pro-I', 'Nokia G42 5G', 'Nokia XR21', 'Nokia C32', 'Nokia 2780 Flip', 'Asus ROG Phone 7 Ultimate', 'Asus Zenfone 10', 'Asus ROG Phone 6 Pro', 'Asus Zenfone 9', 'Realme GT Neo 5', 'Realme 11 Pro+', 'Realme C55', 'Realme Narzo N55', 'Vivo X90 Pro', 'Vivo V29', 'Vivo Y78 Plus'];
    private const TELEVISIONS = ['Samsung QN90C Neo QLED', 'LG C3 OLED', 'Sony A95L QD-OLED', 'TCL 6-Series QLED', 'Hisense U8H Mini-LED', 'Philips OLED807', 'Panasonic LZ2000 OLED', 'Vizio MQX Series', 'Samsung The Frame 2023', 'LG G3 OLED Evo', 'Sony X90L Full Array LED', 'TCL Q7 QLED', 'Hisense U6H Quantum Dot', 'LG B2 OLED', 'Samsung QN85B Neo QLED', 'Sharp Aquos XLED', 'Philips Ambilight OLED+', 'Toshiba Fire TV Edition', 'Sony Bravia XR A80K OLED', 'Panasonic MX800'];
    private const PROJECTORS = ['Epson Home Cinema 5050UB', 'BenQ HT3550', 'Optoma UHD38', 'LG HU810P', 'Samsung The Premiere LSP9T', 'ViewSonic PX701-4K', 'Sony VPL-VW325ES', 'JVC DLA-NX5', 'Anker Nebula Cosmos Max', 'XGIMI Horizon Pro', 'Epson EpiqVision Ultra LS500', 'BenQ TK850i', 'Optoma GT1080HDR', 'LG CineBeam PF610P', 'Xiaomi Mi Smart Projector 2 Pro', 'Hisense PX1-Pro', 'ViewSonic X10-4KE', 'Sony VPL-HW45ES', 'Nebula Capsule II', 'BenQ GS50'];

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private SluggerInterface $slugger, private CategoryRepository $categoryRepository)
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
        $categories = $this->categoryRepository->findWithoutChildren();
        $category = self::faker()->randomElement($categories);

        return [
            'adStatus' => self::faker()->randomElement(AdStatusEnum::cases()),
            'address' => self::faker()->address(),
            'description' => self::faker()->text(),
            'messageContactCount' => self::faker()->randomNumber(2, false),
            'price' => self::faker()->randomNumber(5, false),
            'title' => $this->generateTitleForCategory($category),
            'viewsCount' => self::faker()->randomNumber(2, false),
            'whatsappContactCount' => self::faker()->randomNumber(2, false),
            'category' => $category,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (Ad $ad): void {
                $slug = strtolower($ad->getCategory()->getName().' '.$ad->getTitle().' '.uniqid());
                $ad->setSlug($this->slugger->slug($slug, '_'));
            });
    }

    /**
     * generate a title for an Ad based on a given category.
     */
    private function generateTitleForCategory(Category $category): string
    {
        return match ($category->getName()) {
            'phone' => self::faker()->randomElement(self::PHONES),
            'television' => self::faker()->randomElement(self::TELEVISIONS),
            'projectors' => self::faker()->randomElement(self::PROJECTORS),
            default => self::faker()->sentence(3),
        };
    }
}
