<?php

declare(strict_types=1);

namespace ArmorCMS\User\CommandHandler;

use Doctrine\ORM\EntityManagerInterface;
use ArmorCMS\User\Command\UpdateAvatar;
use ArmorCMS\User\Entity\Avatar;
use ArmorCMS\User\Repository\AvatarRepository;
use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use Symfony\Component\Filesystem\Filesystem;

final readonly class UpdateAvatarCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private string $userAvatarDirectory,
        private AvatarRepository $avatarRepository,
        private Filesystem $filesystem,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(UpdateAvatar $command): void
    {
        /** @var Avatar $avatar */
        $avatar = $this->avatarRepository->findByUuid($command->uuid);
        $this->filesystem->remove(
            sprintf(
                '%s/%s',
                $this->userAvatarDirectory,
                $avatar->getFileName()
            )
        );

        $avatar->changeFileName($command->fileName);
        $avatar->changeOriginalName($command->originalName);

        $this->entityManager->flush();
    }
}
