<?php
declare(strict_types=1);

namespace ArmorCMS\Article\DTO;

use Symfony\Component\Uid\Uuid;

final readonly class GetArticle
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public bool $isActive,
        public string $slug
    ) {
    }
}
