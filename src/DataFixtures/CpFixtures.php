<?php
/**
 * Created by PhpStorm.
 * User: busti
 * Date: 16-10-18
 * Time: 19:59
 */

namespace App\DataFixtures;

use App\Entity\Cp;
use App\Entity\Locality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CpFixtures extends Fixture
{

    public const CP_REFERENCE = 'cp';
    public const LOCALITY_REFERENCE = 'locality';

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');


        $cp = array(4000, 4900, 4607, 4140, 4920, 4960, 4970, 4800, 4860, 4650);
        for($i = 0; $i < 10; $i++){
            $code = new Cp();
            $code->setCp($cp[$i]);
            $manager->persist($code);
            $this->addReference(self::CP_REFERENCE.$i, $code);
        }
        $manager->flush();


        $locality = array('Liège', 'Spa', 'Dalhem', 'Sprimont', 'Aywaille', 'Malmedy', 'Stavelot', 'Verviers', 'Pepinster', 'Herve');
        for($i = 0; $i < 10; $i++){
            $local = new Locality();
            $local->setLocality($locality[$i]);
            $manager->persist($local);
            $this->addReference(self::LOCALITY_REFERENCE.$i, $local);
        }

        $manager->flush();
    }
}