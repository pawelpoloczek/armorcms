<?php
declare(strict_types=1);

namespace ArmorCMS\User\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ArmorCMS\Shared\Trait\Blameable;
use ArmorCMS\Shared\Trait\Identifyable;
use ArmorCMS\Shared\Trait\Timestampable;
use ArmorCMS\User\Repository\AvatarRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AvatarRepository::class)]
#[ORM\Table(name: 'user_avatar')]
class Avatar
{
    use Identifyable;
    use Timestampable;
    use Blameable;

    public function __construct(
        #[ORM\Column(type: UuidType::NAME)]
        private readonly Uuid $uuid,
        #[ORM\Column(type: Types::STRING, length: 255)]
        private string $fileName,
        #[ORM\Column(type: Types::STRING, length: 255)]
        private string $originalName,
        #[ORM\ManyToOne(targetEntity: User::class)]
        #[ORM\JoinColumn(
            name: 'user_id',
            referencedColumnName: 'id',
            unique: true,
            nullable: false
        )]
        private readonly User $user
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function changeFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function changeOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
