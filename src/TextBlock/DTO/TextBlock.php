<?php

declare(strict_types=1);

namespace ArmorCMS\TextBlock\DTO;

use Symfony\Component\Uid\Uuid;

final readonly class TextBlock
{
    public function __construct(
        public Uuid $uuid,
        public string $blockKey,
        public bool $isActive,
        public ?string $description,
    ) {  
    }
}