<?php
declare(strict_types=1);

namespace ArmorCMS\User\CommandHandler;

use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use ArmorCMS\User\Command\CreateUser;
use ArmorCMS\User\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(CreateUser $command): void
    {
        $user = new User(
            $command->uuid,
            $command->username,
            $command->email
        );

        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $command->password)
        );

        if ($command->isAdmin) {
            $user->addRole('ROLE_ADMIN');
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
