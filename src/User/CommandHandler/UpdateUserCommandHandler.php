<?php
declare(strict_types=1);

namespace ArmorCMS\User\CommandHandler;

use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use ArmorCMS\Shared\Service\ImageGarbageCollector;
use ArmorCMS\Shared\Service\ImageResizer;
use ArmorCMS\User\Entity\Avatar;
use ArmorCMS\User\Entity\User;
use ArmorCMS\User\Repository\AvatarRepository;
use ArmorCMS\User\Service\AvatarUploader;
use Doctrine\ORM\EntityManagerInterface;
use ArmorCMS\User\Command\UpdateUser;
use ArmorCMS\User\Repository\UserRepository;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private AvatarRepository $avatarRepository,
        private EntityManagerInterface $entityManager,
        private AvatarUploader $uploader,
        private UuidFactory $uuidFactory,
        private ImageResizer $imageResizer,
        private ImageGarbageCollector $imageGarbageCollector,
        private string $userAvatarDirectory
    ) {
    }

    public function __invoke(UpdateUser $command): void
    {
        $user = $this->userRepository->findByUuid($command->uuid);

        if (null === $user) {
            return;
        }

        $this->changeAdminRole($user, $command->isAdmin);

        if ($command->email !== $user->getEmail()) {
            $user->setEmail($command->email);
        }

        if (null !== $command->avatar) {
            $file = $this->uploader->upload($command->avatar);

            $avatar = $this->avatarRepository->findOneBy(['user' => $user]);
            if (null === $avatar) {
                $avatar = new Avatar(
                    $this->uuidFactory->create(),
                    $file->name,
                    $file->fileName,
                    $user
                );
                $this->entityManager->persist($avatar);
            } else {
                $this->imageGarbageCollector->cleanUp($this->userAvatarDirectory, $avatar->getFileName());

                $avatar->changeOriginalName($file->fileName);
                $avatar->changeFileName($file->name);
            }

            $this->imageResizer->createThumbnails(
                $avatar->getOriginalName(),
                $this->userAvatarDirectory
            );
        }

        $this->entityManager->flush();
    }

    private function changeAdminRole(User $user, bool $isAdmin): void
    {
        if (true === $isAdmin && false === $user->isAdmin()) {
            $user->addRole('ROLE_ADMIN');
        }

        if (false === $isAdmin && true === $user->isAdmin()) {
            $user->removeRole('ROLE_ADMIN');
        }
    }
}
