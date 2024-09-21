<?php
declare(strict_types=1);

namespace ArmorCMS\User\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

final readonly class UpdateUser
{
    public function __construct(
        public Uuid $uuid,
        public string $email,
        public bool $isAdmin,
        public ?UploadedFile $avatar
    ) {
    }
}
