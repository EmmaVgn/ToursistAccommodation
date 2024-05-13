<?php

namespace App\DataFixtures;

use App\Entity\Add;
use Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AddsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('fr_FR');

        for($a = 1; $a <= 10; $a++){
            $add = new Add();
            $add->setTitle($faker->Text(50));
            $add->setSlug($this->slugger->slug($add->getTitle())->lower());
            $add->setPrice($faker->numberBetween(25000, 100000));
            $add->setCapacity($faker->numberBetween(1, 20));
            $add->setRooms($faker->numberBetween(1, 6));
            $add->setDescription($faker->paragraph(3));
            $add->setIntroduction($faker->text(150));
      

       

            $manager->persist($add);
        }

        $manager->flush();
    }
}
