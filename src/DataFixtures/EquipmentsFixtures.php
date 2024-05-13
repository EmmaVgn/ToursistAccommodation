<?php

namespace App\DataFixtures;

use App\Entity\Add;
use App\Entity\Equipment;
use Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class EquipmentsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('fr_FR');

        $equipments = ['wifi', 'tv', 'climatiseur', 'lave-linge', 'lave-vaisselle', 'piscine', 'jacuzzi', 'parking'];
        $equipmentArray = [];
        for ($i = 0; $i < count($equipments); $i++) {
            $equipment = new Equipment();
            $equipment->setName($equipments[$i]);
            $manager->persist($equipment);
            array_push($equipmentArray, $equipment);
        }

        $manager->flush();
    }
}
