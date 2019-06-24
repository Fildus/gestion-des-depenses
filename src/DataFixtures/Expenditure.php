<?php

namespace App\DataFixtures;

use App\Entity\SourceAccount;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Expenditure extends Fixture
{
    /**
     * @var array
     */
    private $account;

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++){
            $account = new SourceAccount();
            $account->setName($faker->domainName);
            $this->account[] = $account;
            $manager->persist($account);
        }

        for ($i = 0; $i < 1000; $i++) {

            $e = new \App\Entity\Expenditure();
            $e->setTitle($faker->title);
            $e->setSociety($faker->company);
            $e->setCategory($faker->word);
            $e->setType($faker->word);
            $e->setSourceAccount($this->account[random_int(0,9)]);
            $e->setNote($faker->text);
            $e->setDate($faker->dateTimeBetween('-2 years', '2 years'));
            $e->setAmount($faker->numberBetween('10','10000'));
            $manager->persist($e);
        }
        $manager->flush();
    }
}
