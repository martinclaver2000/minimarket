<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Factory\AccountFactory;
use App\Factory\AdFactory;
use App\Factory\CategoryFactory;
use App\Factory\FavoriteFactory;
use App\Factory\ImageFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $users = UserFactory::createMany(10);

        foreach ($users as $user) {
            AccountFactory::createOne(['owner' => $user]);
        }

        $this->createCategories();

        AdFactory::createMany(100, function () {
            return [
                'account' => AccountFactory::random(),
            ];
        });

        ImageFactory::createMany(100, function () {
            return ['ad' => AdFactory::random()];
        });

        FavoriteFactory::createMany(100, function () {
            return [
                'ad' => AdFactory::random(),
                'owner' => UserFactory::random(),
            ];
        });
    }

    /**
     * Fonction récursive pour créer les catégories.
     *
     * @param Category[]|null $categories
     */
    public function createCategories(?Category $parent = null, ?array $categories = null): void
    {
        // Si aucun tableau de catégories n'est passé, on utilise le tableau de base
        $categories = $categories ?? $this->getCategories();

        foreach ($categories as $categoryName => $subCategories) {
            // Créer la catégorie actuelle avec son parent (ou null pour les catégories racines)
            $category = CategoryFactory::createOne([
                'name' => $categoryName,
                'parent' => $parent,
            ]);

            // Appel récursif pour les sous-catégories
            if (is_array($subCategories) && !empty($subCategories)) {
                $this->createCategories($category, $subCategories);
            }
        }
    }

    /**
     * Undocumented function.
     *
     * @return mixed []
     */
    private function getCategories(): array
    {
        return [
            'Transport' => [
                'automobile' => [],
                'moto' => [],
                'water carriage' => [],
                'trucks and special equipment' => [],
                'parts and accessories' => [],
            ],
            'Real estate' => [],
            'Electronics' => [],
            'Jobs' => [],
            'Services' => [],
            'Personal articles' => [
                'clothes, shoes, accessories' => [],
                'beauty and health' => [],
                'watches and jewelry' => [],
                'children\'s clothing and footwear' => [],
                'children\'s goods and toys' => [],
            ],
            'For home and garden' => [],
            'Hobbies and recreation' => [],
            'Animals' => [
                'cat' => [],
                'dog' => [],
                'horse' => [],
                'lion' => [],
                'other' => [],
            ],
            'Business and equipments' => [],
        ];
    }
}
