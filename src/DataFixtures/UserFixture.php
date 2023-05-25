<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->word());
            $user->setPassword();
            $user->setRole();
            $user->setFirstName();
            $user->setLastName();
            $user->setPhone();
            $user->setCreated();
            $manager->persist($user);
            // $product = new Product();
            // $manager->persist($product);
        }

        $manager->flush();
    }
}