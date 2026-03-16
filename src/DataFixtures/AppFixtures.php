<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Chien;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $donneesChiens = [
            ['nom' => 'Rex', 'race' => 'bulldog Algerien', 'age' => 55],
            ['nom' => 'Rocky', 'race' => 'Boxer', 'age' => 4],
            ['nom' => 'Nala', 'race' => 'Caniche', 'age' => 2],
            ['nom' => 'Django', 'race' => 'Staffie', 'age' => 6],
            ['nom' => 'Mochi', 'race' => 'Carlin', 'age' => 1],
            ['nom' => 'Youssef', 'race' => 'chien très très mechant', 'age' => 19],
            ['nom' => 'Youssef', 'race' => 'chien très très mechant', 'age' => 20],
        ];

        foreach ($donneesChiens as $data) {
            $chien = new Chien();
            $chien->setNom($data['nom']);
            $chien->setRace($data['race']);
            $chien->setAge($data['age']);
            $manager->persist($chien);
        }

        $manager->flush();
    }
}
