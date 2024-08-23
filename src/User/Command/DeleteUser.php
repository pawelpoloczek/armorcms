<?php
declare(strict_types=1);

namespace ArmorCMS\User\Command;

use Symfony\Component\Uid\Uuid;

final readonly class DeleteUser
{
    public function __construct(
        public Uuid $uuid
    ) {
    }
}
