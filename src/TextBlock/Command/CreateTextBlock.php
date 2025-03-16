<?php

declare(strict_types=1);

namespace ArmorCMS\TextBlock\Command;

use Symfony\Component\Uid\Uuid;

final readonly class CreateTextBlock
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public bool $isActive,
        public string $content,
    ) {}
}
