<?php
declare(strict_types=1);

namespace ArmorCMS\User\Command;

use Symfony\Component\Uid\Uuid;

final readonly class UpdateUserPassword
{
    public function __construct(
        public Uuid $uuid,
        public string $password
    ) {
    }
}
