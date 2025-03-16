<?php

declare(strict_types=1);

namespace ArmorCMS\TextBlock\DTO;

final readonly class TextBlock
{
    public function __construct(
        public bool $isActive,
        public string $content,
    ) {  
    }
}