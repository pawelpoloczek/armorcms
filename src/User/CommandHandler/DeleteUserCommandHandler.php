<?php
declare(strict_types=1);

namespace ArmorCMS\User\CommandHandler;

use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use ArmorCMS\User\Command\DeleteUser;
use ArmorCMS\User\Repository\UserRepository;

final readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(DeleteUser $command): void
    {
        $user = $this->userRepository->findByUuid($command->uuid);

        if (null === $user) {
            return;
        }

        $user->delete();

        $this->entityManager->flush();
    }
}
