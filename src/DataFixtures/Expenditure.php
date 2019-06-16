<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Expenditure extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 1000; $i++) {
            $e = new \App\Entity\Expenditure();
            $e->setTitle($faker->title);
            $e->setSociety($faker->company);
            $e->setCategory($faker->word);
            $e->setType($faker->word);
            $e->setSourceAccount($faker->bankAccountNumber);
            $e->setNote($faker->text);
            $e->setDate($faker->dateTimeBetween('-2 years', '2 years'));
            $e->setAmount($faker->numberBetween('10','10000'));
            $manager->persist($e);
        }


        $manager->flush();
    }
}
