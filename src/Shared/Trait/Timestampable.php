<?php
declare(strict_types=1);

namespace ArmorCMS\Shared\Trait;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable as GedmoTimestampable;

trait Timestampable
{
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[GedmoTimestampable(on: 'create')]
    protected ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(
        type: Types::DATETIME_IMMUTABLE,
        nullable: true,
        options: ["default" => null]
    )]
    #[GedmoTimestampable(on: 'update')]
    protected ?DateTimeImmutable $updatedAt = null;

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
