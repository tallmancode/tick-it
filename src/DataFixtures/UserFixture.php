<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $seedUsers = [
            [
                'email' => 'bob@support.com',
                'roles' => ['ROLE_SUPPORT']
            ],
            [
                'email' => 'sue@support.com',
                'roles' => ['ROLE_SUPPORT']
            ],
            [
                'email' => 'randy@support.com',
                'roles' => ['ROLE_SUPPORT']
            ]
        ];

        foreach($seedUsers as $user) {
            UserFactory::findOrCreate($user);
        }

        $manager->flush();
    }
}
