<?php
declare(strict_types=1);

namespace ArmorCMS\User\DTO;

use Symfony\Component\Uid\Uuid;

final readonly class GetUser
{
    public function __construct(
        public Uuid $uuid,
        public string $username,
        public string $email,
        public bool $isAdmin
    ) {
    }
}
