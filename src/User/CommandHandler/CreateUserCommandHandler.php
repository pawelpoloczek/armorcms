<?php
declare(strict_types=1);

namespace ArmorCMS\User\CommandHandler;

use ArmorCMS\Shared\CommandHandler\CommandHandlerInterface;
use ArmorCMS\Shared\Service\ImageResizer;
use ArmorCMS\User\Entity\Avatar;
use ArmorCMS\User\Service\AvatarUploader;
use Doctrine\ORM\EntityManagerInterface;
use ArmorCMS\User\Command\CreateUser;
use ArmorCMS\User\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private AvatarUploader $uploader,
        private UuidFactory $uuidFactory,
        private ImageResizer $imageResizer,
        private string $userAvatarDirectory
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

        if (null !== $command->avatar) {
            $file = $this->uploader->upload($command->avatar);
            $avatar = new Avatar(
                $this->uuidFactory->create(),
                $file->name,
                $file->fileName,
                $user
            );
            $this->entityManager->persist($avatar);

            $this->imageResizer->createThumbnails(
                $avatar->getOriginalName(),
                $this->userAvatarDirectory
            );
        }

        $this->entityManager->flush();
    }
}
