<?php

namespace App\DataFixtures;

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

        CategoryFactory::createMany(10);

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
}
