<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Cp;
use App\Entity\Locality;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Vendor;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class VendorFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        $adminUser = new Client();
        $adminUser->addRole('ROLE_ADMIN');

        $adminUser->setName('Jon')
            ->setFamilyName('Bubu')
            ->setNewsLetter(false)
            ->setEmail('jon@symfony.com')
            ->setPassword($this->encoder->encodePassword($adminUser, '123456789'))
            ->setDate($faker->dateTimeBetween('-30 years', 'now'))
            ->setInscription(true)
            ->setTry(0)
            ->setAdresse('Rue de l\'administration')
            ->setNumber(rand(1, 999))
            ->setBanni(true);

        /**
         * @var $cpdataadmin Cp
         * @var $localitydataadmin Locality
         */
        $randadmin = rand(0,9);

        $cpdataadmin = $this->getReference(CpFixtures::CP_REFERENCE.$randadmin);
        $localitydataadmin = $this->getReference(CpFixtures::LOCALITY_REFERENCE.$randadmin);


        $adminUser->setCp($cpdataadmin)
            ->setLocality($localitydataadmin);

        $manager->persist($adminUser);

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
                   ->setBanni($faker->boolean(85))
                   ->setDate($faker->dateTimeBetween('-30 years', 'now'))
                   ->setInscription($faker->boolean(100))
                   ->setTry(0)
                   ->setPassword($this->encoder->encodePassword($vendor, '123456789'));

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
