<?php
declare(strict_types=1);

namespace ArmorCMS\Page\DTO;

use Symfony\Component\Uid\Uuid;

final readonly class Page
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public bool $isActive,
        public string $slug
    ) {
    }
}
