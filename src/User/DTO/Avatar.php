<?php

declare(strict_types=1);

namespace ArmorCMS\User\DTO;

use Symfony\Component\Uid\Uuid;

final readonly class Avatar
{
    public function __construct(
        public Uuid $uuid,
        public string $fileName,
        public string $originalName
    ) {
    }
}
