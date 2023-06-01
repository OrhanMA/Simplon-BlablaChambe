<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
// use Faker\Provider\PhoneNumber;
use DateTime;


class UserFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        // $this->faker->addProvider(new PhoneNumber($this->faker));
        // $roles = ['Utilisateur', 'Administrateur'];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setPassword($this->faker->password(8, 16));
            // $user->setRoles($this->faker->randomElement($role));
            // $user->setRoles($roles);
            // $user->setRoles($roles[$this->faker->numberBetween(0, 1)]);
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setPhone($this->faker->phoneNumber());
            $user->setCreated(new DateTime);
            // $user->setCreated();
            $manager->persist($user);
            $this->setReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}