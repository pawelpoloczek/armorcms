<?php
declare(strict_types=1);

namespace ArmorCMS\User\CommandHandler;

use Doctrine\ORM\EntityManagerInterface;
use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use ArmorCMS\User\Command\CreateAvatar;
use ArmorCMS\User\Entity\Avatar;
use ArmorCMS\User\Repository\UserRepository;

final readonly class CreateAvatarCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(CreateAvatar $command): void
    {
        $avatar = new Avatar(
            $command->uuid,
            $command->fileName,
            $command->originalName,
            $this->userRepository->findByUuid($command->contactId)
        );

        $this->entityManager->persist($avatar);
        $this->entityManager->flush();
    }
}
