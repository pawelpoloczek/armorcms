<?php
declare(strict_types=1);

namespace ArmorCMS\Page\DTO;

use Symfony\Component\Uid\Uuid;

final readonly class Seo
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public string $description,
        public array $robots,
        public string $ogTitle,
        public string $ogDescription,
        public string $ogSection,
        public array $ogTags
    ) {
    }
}