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
        $user->setEmail('admin@test');
        $user->setRoles(['USER_ROLE', 'ADMIN_ROLE']);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                'admin'
            )
        );
        $manager->persist($user);
        $manager->flush();
    }
}
