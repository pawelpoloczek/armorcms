<?php
declare(strict_types=1);

namespace ArmorCMS\User\CommandHandler;

use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use ArmorCMS\User\Command\UpdateUser;
use ArmorCMS\User\Repository\UserRepository;

final readonly class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(UpdateUser $command): void
    {
        $user = $this->userRepository->findByUuid($command->uuid);

        if (null === $user) {
            return;
        }

        if (false === $user->isAdmin() && true === $command->isAdmin) {
            $user->addRole('ROLE_ADMIN');
        }

        if (true === $user->isAdmin() && false === $command->isAdmin) {
            $user->removeRole('ROLE_ADMIN');
        }

        if ($command->email !== $user->getEmail()) {
            $user->setEmail($command->email);
        }

        $this->entityManager->flush();
    }
}
