<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ride;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use DateTime;

class RideFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $ride = new Ride();
            $ride->setDriver($this->getReference("user_" . $this->faker->numberBetween(0, 9)));
            for ($y = 1; $y < $this->faker->numberBetween(1, 3); $y++) {
                $ride->addRule($this->getReference("rule_" . $this->faker->numberBetween(0, 3)));
            }
            $ride->setDeparture($this->faker->city());
            $ride->setDestination($this->faker->city());
            $ride->setSeats($this->faker->numberBetween(1, 5));
            $ride->setPrice($this->faker->numberBetween(5, 35));
            $ride->setDate($this->faker->dateTimeThisMonth());
            $ride->setCreated(new DateTime);
            $manager->persist($ride);
            $this->setReference('ride_' . $i, $ride);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixture::class,
            RuleFixture::class,
        ];
    }
}