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
                'email' => 'user@user.com'
            ],
            [
                'email' => 'user1@support.com',
                'roles' => ['ROLE_SUPPORT']
            ],
            [
                'email' => 'user2@support.com',
                'roles' => ['ROLE_SUPPORT']
            ],
            [
                'email' => 'user3@support.com',
                'roles' => ['ROLE_SUPPORT']
            ]
        ];

        foreach($seedUsers as $user) {
            UserFactory::findOrCreate($user);
        }

        $manager->flush();
    }
}
