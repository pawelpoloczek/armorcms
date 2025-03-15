<?php

declare(strict_types=1);

namespace ArmorCMS\Page\Entity;

use ArmorCMS\Page\Repository\PageRepository;
use ArmorCMS\Shared\Trait\Blameable;
use ArmorCMS\Shared\Trait\Identifyable;
use ArmorCMS\Shared\Trait\SoftDeletable;
use ArmorCMS\Shared\Trait\Timestampable;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table(name: "page")]
class Page
{
    use Identifyable;
    use Timestampable;
    use Blameable;
    use SoftDeletable;

    public function __construct(
        #[ORM\Column(type: UuidType::NAME)]
        private readonly Uuid $uuid,
        #[ORM\Column(type: Types::STRING, length: 255)]
        private string $title,
        #[ORM\Column(type: Types::BOOLEAN)]
        private bool $isActive,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
        private ?DateTimeImmutable $publicationDate,
        #[ORM\Column(type: Types::STRING, length: 127, nullable: true)]
        private ?string $author,
        #[ORM\Column(type: Types::TEXT)]
        private string $content,
        #[ORM\OneToOne(targetEntity: Route::class)]
        #[ORM\JoinColumn(name: 'route_id', referencedColumnName: 'id')]
        private readonly Route $route,
        #[ORM\OneToOne(targetEntity: Seo::class)]
        #[ORM\JoinColumn(name: 'seo_id', referencedColumnName: 'id')]
        private readonly Seo $seo
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function changeTitle(string $title): void
    {
        $this->title = $title;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function changeActivity(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getPublicationDate(): ?DateTimeImmutable
    {
        return $this->publicationDate;
    }

    public function changePublicationDate(DateTimeImmutable $publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function changeAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function changeContent(string $content): void
    {
        $this->content = $content;
    }

    public function getSeo(): Seo
    {
        return $this->seo;
    }

    public function getRoute(): Route
    {
        return $this->route;    
    }
}