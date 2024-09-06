<?php
declare(strict_types=1);

namespace ArmorCMS\User\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

final readonly class CreateUser
{
    public function __construct(
        public Uuid $uuid,
        public string $username,
        public string $email,
        public string $password,
        public bool $isAdmin,
        public ?UploadedFile $avatar
    ) {
    }
}
