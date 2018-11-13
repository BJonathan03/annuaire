<?php

namespace App\DataFixtures;

use App\Entity\Cp;
use App\Entity\Locality;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Vendor;

class VendorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 15; $i++){
            $vendor = new Vendor();
            $vendor->setName($faker->company)
                   ->setEmailContact($faker->email)
                   ->setWebsite($faker->url)
                   ->setPhone($faker->phoneNumber)
                   ->setTva($faker->creditCardNumber)
                   ->setEmail($faker->safeEmail)
                   ->setAdresse($faker->streetName)
                   ->setNumber(rand(1, 999))
                   ->setBanni($faker->boolean(50))
                   ->setDate($faker->dateTimeBetween('-30 years', 'now'))
                   ->setInscription($faker->boolean(75))
                   ->setTry(0)
                   ->setPassword($faker->password);

            $rand = rand(0,9);

            /**
             * @var $cpdata Cp
             * @var $localitydata Locality
             */

            $cpdata = $this->getReference(CpFixtures::CP_REFERENCE.$rand);
            $localitydata = $this->getReference(CpFixtures::LOCALITY_REFERENCE.$rand);


            $vendor->setCp($cpdata)
                   ->setLocality($localitydata);


            $max = rand(1, 4);

            for($j=0; $j < $max ; $j++){

                /**
                 * @var $services Service
                 */

                $ser = rand(0,9);
                $services = $this->getReference(AnnuaireFixtures::SERVICES_REFERENCE.$ser);
                $vendor->addService($services);

            }
        $manager->persist($vendor);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CpFixtures::class,
            AnnuaireFixtures::class
        );
    }
}
