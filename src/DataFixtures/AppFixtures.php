<?php

namespace App\DataFixtures;

use App\Entity\Medal;
use App\Entity\Nation;
use App\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nations = [
            [
                'Afrique du Sud',
                'za',
            ],
            [
                'Cameroun',
                'cm',
            ],
            [
                'Djibouti',
                'dj',
            ],
            [
                'Érythrée',
                'er',
            ],
            [
                'Éthiopie',
                'et',
            ],
            [
                'Allemagne',
                'de',
            ],
            [
                'Arménie',
                'am',
            ],
            [
                'Autriche',
                'at',
            ],
            [
                'Azerbaïdjan',
                'az',
            ],
            [
                'Belgique',
                'be',
            ],
            [
                'Bulgarie',
                'bg',
            ],
            [
                'Croatie',
                'hr',
            ],
            [
                'Espagne',
                'es',
            ],
            [
                'Estonie',
                'ee',
            ],
            [
                'Finlande',
                'fi',
            ],
            [
                'France',
                'fr',
            ],
            [
                'Équateur',
                'ec',
            ],
            [
                'États-Unis',
                'us',
            ],
            [
                'Guatemala',
                'gt',
            ],
            [
                'Jamaïque',
                'jm',
            ],
        ];

        $sports = [
            [
                'Athlétisme',
                null,
            ],
            [
                'Aviron',
                null,
            ],
            [
                'Badminton',
                null,
            ],
            [
                'Basket-ball',
                'Basket-ball à 5',
            ],
            [
                'Basket-ball',
                'Basket-ball à 3',
            ],
            [
                'Boxe',
                null,
            ],
            [
                'Breakdance',
                null,
            ],
            [
                'Canoë-kayak',
                'En eau calme',
            ],
            [
                'Canoë-kayak',
                'En eau vive / Slalom',
            ],
            [
                'Cyclisme',
                'BMX',
            ],
            [
                'Cyclisme',
                'Sur piste',
            ],
            [
                'Cyclisme',
                'Sur route',
            ],
            [
                'Cyclisme',
                'VTT',
            ],
            [
                'Équitation',
                null,
            ],
            [
                'Escalade',
                null,
            ],
            [
                'Escrime',
                null,
            ],
            [
                'Football',
                null,
            ],
        ];

        $allNations = new ArrayCollection();

        foreach ($nations as $nationData) {
            $nation = new Nation();
            $nation
                ->setName($nationData[0])
                ->setCode($nationData[1]);
            $manager->persist($nation);
            $allNations->add($nation);
        }

        foreach ($sports as $sportData) {
            $sport = new Sport();
            $sport->setName($sportData[0]);

            if ($sportData[1]) {
                $sport->setCategory($sportData[1]);
            }

            $manager->persist($sport);

            $orNationId = mt_rand(0, $allNations->count() - 1);

            $argentNationId = null;
            while (!$argentNationId) {
                $selected = mt_rand(0, $allNations->count() - 1);
                if ($selected != $orNationId) {
                    $argentNationId = $selected;
                }
            }

            $bronzeNationId = null;
            while (!$bronzeNationId) {
                $selected = mt_rand(0, $allNations->count() - 1);
                if ($selected != $orNationId && $selected != $argentNationId) {
                    $bronzeNationId = $selected;
                }
            }

            $nationOr = $allNations->get($orNationId);
            $medalOr = new Medal();
            $medalOr
                ->setColor(Medal::COLOR_OR)
                ->setSport($sport)
                ->setNation($nationOr);
            $manager->persist($medalOr);

            $nationArgent = $allNations->get($argentNationId);
            $medalArgent = new Medal();
            $medalArgent
                ->setColor(Medal::COLOR_ARGENT)
                ->setSport($sport)
                ->setNation($nationArgent);
            $manager->persist($medalArgent);

            $nationBronze = $allNations->get($bronzeNationId);
            $medalBronze = new Medal();
            $medalBronze
                ->setColor(Medal::COLOR_BRONZE)
                ->setSport($sport)
                ->setNation($nationBronze);
            $manager->persist($medalBronze);
        }

        $manager->flush();
    }
}
