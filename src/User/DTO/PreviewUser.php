<?php
declare(strict_types=1);

namespace ArmorCMS\User\DTO;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final readonly class PreviewUser
{
    public function __construct(
        public Uuid $uuid,
        public DateTimeImmutable $createdAt,
        public ?DateTimeImmutable $updatedAt,
        public string $createdBy,
        public ?string $updatedBy,
        public string $username,
        public string $email,
        public bool $isAdmin,
        public array $roles,
        public ?Avatar $avatar,
    ) {
    }
}
