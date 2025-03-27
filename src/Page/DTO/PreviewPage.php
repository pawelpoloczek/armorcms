<?php

declare(strict_types=1);

namespace ArmorCMS\Page\DTO;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final readonly class PreviewPage
{
    public function __construct(
        public Uuid $uuid,
        public DateTimeImmutable $createdAt,
        public ?DateTimeImmutable $updatedAt,
        public string $createdBy,
        public ?string $updatedBy,
        public string $title,
        public bool $isActive,
        public string $slug,
        public ?DateTimeImmutable $publicationDate,
        public ?string $author,
        public PreviewSeo $seo,
    ) {}
}
