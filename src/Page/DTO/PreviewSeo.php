<?php

declare(strict_types=1);

namespace ArmorCMS\Page\DTO;

final readonly class PreviewSeo
{
    public function __construct(
        public ?string $title,
        public ?string $description,
        public array $robots,
        public ?string $ogTitle,
        public ?string $ogDescription,
        public ?string $ogSection,
        public array $ogTags
    ) {}
}
