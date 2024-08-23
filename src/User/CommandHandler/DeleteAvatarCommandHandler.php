<?php
declare(strict_types=1);

namespace ArmorCMS\User\CommandHandler;

use Doctrine\ORM\EntityManagerInterface;
use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use ArmorCMS\User\Command\DeleteAvatar;
use ArmorCMS\User\Repository\AvatarRepository;
use Symfony\Component\Filesystem\Filesystem;

use function sprintf;

final readonly class DeleteAvatarCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private string $userAvatarDirectory,
        private AvatarRepository $avatarRepository,
        private Filesystem $filesystem,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(DeleteAvatar $command): void
    {
        $avatar = $this->avatarRepository->findByUuid($command->uuid);

        if (null === $avatar) {
            return;
        }

        $this->filesystem->remove(
            sprintf(
                '%s/%s',
                $this->userAvatarDirectory,
                $avatar->getFileName()
            )
        );
        $this->entityManager->remove($avatar);
        $this->entityManager->flush();
    }
}
