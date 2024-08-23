<?php
declare(strict_types=1);

namespace ArmorCMS\Shared\Trait;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SoftDeletable
{
    #[ORM\Column(
        type: Types::DATETIME_IMMUTABLE,
        nullable: true,
        options: ["default" => null]
    )]
    protected ?DateTimeImmutable $deletedAt = null;

    public function delete(): void
    {
        $this->deletedAt = new DateTimeImmutable();
    }

    public function isDeleted(): bool
    {
        return null !== $this->deletedAt;
    }

    public function getDeletionDate(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
