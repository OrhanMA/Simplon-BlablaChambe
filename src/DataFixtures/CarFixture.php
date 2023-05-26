<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Provider\Fakecar;
use DateTime;

class CarFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->faker->addProvider(new Fakecar($this->faker));
        for ($i = 0; $i < 10; $i++) {
            $car = new Car();
            $model = $this->faker->vehicle();
            $modelArray = explode(' ', $model);
            // $car->setBrand('Audi');
            $car->setBrand($modelArray[0]);
            $car->setModel($modelArray[1]);
            $car->setSeats($this->faker->numberBetween(1, 5));
            $car->setCreated(new DateTime);
            $car->setOwner($this->getReference("user_" . $this->faker->numberBetween(0, 9)));

            $manager->persist($car);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}