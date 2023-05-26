<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Rule;

class RuleFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $passengerRules = [
            (object) [
                'rule' => "Pas d'appels",
                'description' => "Pas d'appel pendant le trajet sauf urgence pour ne pas distraire le conducteur.",
            ],
            (object) [
                'rule' => 'Pas de boissons',
                'description' => 'Boissons interdites dans la voiture afin de ne pas salir.',
            ],
            (object) [
                'rule' => 'Pas de nourriture',
                'description' => 'Nourritures interdites dans la voiture afin de ne pas salir (sauf cas particuliers).',
            ],
            (object) [
                'rule' => 'Pas de musique',
                'description' => 'Musique interdite dans la voiture afin de ne deconcentrer le conducteur.',
            ],
        ];
        for ($i = 0; $i < 4; $i++) {
            $rule = new Rule();

            $rule->setName($passengerRules[$i]->rule);
            $rule->setDescription($passengerRules[$i]->description);
            $rule->setAuthor($this->getReference("user_" . $this->faker->numberBetween(0, 9)));
            $manager->persist($rule);
            $this->setReference('rule_' . $i, $rule);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}