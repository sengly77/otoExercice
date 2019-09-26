<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PersonneFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //$datenow =  new \DateTime();

        //$datenowConvert = strtotime($datenow);
        //$datenowConvert = $datenow->format("Y-m-d");
        //$int= mt_rand(1062015681,1862059999);
        //$datenow = date("Y-m-d H:i:s",$int);
        //$y = mt_rand(1900,3000);
        //$m = mt_rand(1,12);
        //$d = mt_rand(1,31);
        //$datenow2 = new \DateTime($datenow);

        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 40; $i++) {

            $int = mt_rand(1062015681,1862059999);
            $datenow = date("Y-m-d H:i:s",$int);
            $dateRandom = new \DateTime($datenow);

            $personne = new Personne();
            $personne
                ->setNom($faker->words(1, true))
                ->setPrenom($faker->words(1, true))
                ->setDate($dateRandom)
                ->setAge($faker->numberBetween(1,80));
            $manager->persist($personne);
        }

        $manager->flush();
    }
}
