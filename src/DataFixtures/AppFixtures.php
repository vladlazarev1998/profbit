<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Enum\ProductType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++) {
            $product = new Product();
            $product->setCode($this->faker->numberBetween(1, 10));
            $product->setName($this->faker->domainName);
            $product->setType($this->faker->randomElement(ProductType::values()));
            $product->setPrice($this->faker->numberBetween(100, 1000));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
