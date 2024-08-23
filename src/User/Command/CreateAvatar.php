<?php

declare(strict_types=1);

namespace ArmorCMS\User\Command;

use Symfony\Component\Uid\Uuid;

final readonly class CreateAvatar
{
    public function __construct(
        public Uuid $uuid,
        public string $fileName,
        public string $originalName,
        public Uuid $contactId
    ) {
    }
}
