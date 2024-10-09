<?php
declare( strict_types=1 );

namespace ArmorCMS\Page\Command;

use ArmorCMS\Page\DTO\Seo;
use Symfony\Component\Uid\Uuid;

final readonly class CreatePage
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public string $slug,
        public bool $isActive,
        public ?string $author,
        public string $content,
        public Seo $seo
    ) {
    }
}