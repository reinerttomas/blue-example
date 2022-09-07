<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $contact = new Contact(
                $faker->firstName,
                $faker->lastName,
                $faker->email,
                $faker->userName,
            );

            if ($i % 2 === 0) {
                $contact->changePhone($faker->phoneNumber)
                    ->changeNote($faker->text);
            }

            $manager->persist($contact);
        }

        $manager->flush();
    }
}
