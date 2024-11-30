<?php

declare(strict_types=1);

namespace ArmorCMS\Page\Command;

use Symfony\Component\Uid\Uuid;

final readonly class DeletePage
{
    public function __construct(
        public Uuid $uuid
    ) {
    }
}
