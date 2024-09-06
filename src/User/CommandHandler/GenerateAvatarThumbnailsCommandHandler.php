<?php
declare(strict_types=1);

namespace ArmorCMS\User\CommandHandler;

use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use ArmorCMS\Shared\Service\ImageResizer;
use ArmorCMS\User\Command\GenerateAvatarThumbnails;
use ArmorCMS\User\Repository\AvatarRepository;
use ArmorCMS\User\Repository\UserRepository;

final readonly class GenerateAvatarThumbnailsCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private AvatarRepository $avatarRepository,
        private ImageResizer $imageResizer,
        private string $userAvatarDirectory
    ) {
    }

    public function __invoke(GenerateAvatarThumbnails $command): void
    {
        $user = $this->userRepository->findByUuid($command->userUuid);
        if (null === $user) {
            return;
        }

        $avatar = $this->avatarRepository->findOneBy([
            'user' => $user
        ]);

        if (null === $avatar) {
            return;
        }

        $this->imageResizer->createThumbnails(
            $avatar->getOriginalName(),
            $this->userAvatarDirectory
        );
    }
}
