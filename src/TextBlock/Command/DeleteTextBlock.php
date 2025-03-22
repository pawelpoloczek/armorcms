<?php

declare(strict_types=1);

namespace ArmorCMS\TextBlock\Command;

use Symfony\Component\Uid\Uuid;

final readonly class DeleteTextBlock
{
    public function __construct(
        public Uuid $uuid
    ) {
    }
}
