<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
        
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@test');
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                'user'
            )
        );
        $manager->persist($user);

        $userAdmin = new User();
        $userAdmin->setEmail('admin@test');
        $userAdmin->setRoles(['USER_ROLE', 'ROLE_ADMIN']);
        $userAdmin->setPassword(
            $this->userPasswordHasher->hashPassword(
                $userAdmin,
                'admin'
            )
        );
        $manager->persist($userAdmin);
        $manager->flush();
    }
}
