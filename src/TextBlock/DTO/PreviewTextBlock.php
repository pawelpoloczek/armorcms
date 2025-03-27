<?php

declare(strict_types=1);

namespace ArmorCMS\TextBlock\DTO;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final readonly class PreviewTextBlock
{
    public function __construct(
        public Uuid $uuid,
        public DateTimeImmutable $createdAt,
        public ?DateTimeImmutable $updatedAt,
        public string $createdBy,
        public ?string $updatedBy,
        public string $blockKey,
        public bool $isActive,
        public ?string $description,
        public string $content,
    ) {  
    }
}