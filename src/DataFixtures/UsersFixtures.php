<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
    ){}

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@gmail.fr');
        $admin->setLastname('Vigneron');
        $admin->setFirstname('Emma');
        $admin->setAddress('5110 Avenue des pyrénées');
        $admin->setPostalCode('75001');
        $admin->setCity('Paris');
        $admin->setCountry('FR');
        $admin->setPhone('0606060606');
        $admin->setImages('https://randomuser.me/api/portraits');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <= 15; $usr++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setPostalCode(str_replace(' ', '', $faker->postcode));
            $user->setCity($faker->city);
            $user->setCountry($faker->countryCode);
            $user->setPhone($faker->phoneNumber);
            $user->setImages($faker->imageUrl(640, 480, 'people', true));
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            );
          
           
            $manager->persist($user);
        }

        $manager->flush();
    }
}