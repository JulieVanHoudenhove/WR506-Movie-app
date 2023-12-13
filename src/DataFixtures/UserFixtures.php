<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    public function __construct(protected UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (range(1, 5) as $i) {
            $user = new User();
            $user->setEmail('user' . $i . '@gmail.com');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password' . $i));
            $user->setUsername('user_' . $i);
            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setUsername('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $this->addReference('admin_', $admin);
        $manager->persist($admin);

        $manager->flush();
    }
}
