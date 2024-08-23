<?php
declare(strict_types=1);

namespace ArmorCMS\User\DataFixtures;

use Gedmo\Blameable\BlameableListener;
use ArmorCMS\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Component\Uid\Uuid;

final class UserFixtures extends Fixture
{
    public const ROOT_UUID = '018c654b-f758-778e-ab9b-4d7eee65563c';

    public function __construct(
        private readonly BlameableListener           $blameableListener,
        private readonly UuidFactory                 $uuidFactory,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->blameableListener->setUserValue(self::ROOT_UUID);

        $root = new User(
            Uuid::fromString(self::ROOT_UUID),
            'root',
            'root@example.com'
        );
        $root->addRole('ROLE_ROOT');
        $root->setPassword(
            $this->passwordHasher->hashPassword($root, 'root')
        );

        $manager->persist($root);

        $admin = new User(
            $this->uuidFactory->create(),
            'admin',
            'admin@example.com'
        );
        $admin->addRole('ROLE_ADMIN');
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin')
        );

        $manager->persist($admin);

        $manager->flush();
    }
}
