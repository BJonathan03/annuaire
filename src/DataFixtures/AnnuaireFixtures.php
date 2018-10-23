<?php

namespace App\DataFixtures;


use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AnnuaireFixtures extends Fixture
{

    public const SERVICES_REFERENCE = 'services';

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++){
            $service = new Service();
            $service->setName($faker->words(2, true))
                ->setDescription($faker->paragraph(3, true))
                ->setFront(false)
                ->setValidity($faker->boolean(50));

            $manager->persist($service);
            $this->addReference(self::SERVICES_REFERENCE.$i, $service);
        }

        $manager->flush();
    }
}
