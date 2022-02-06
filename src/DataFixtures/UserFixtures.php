<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUuid(Uuid::v1())
            ->setPassword('$2y$13$RaeKqdknCsvV3Mgv9RRKaebFVCandY4XwKGshn7DUV/dtFgh4dZP6');

        $manager->persist($user);
        $manager->flush();
    }
}
