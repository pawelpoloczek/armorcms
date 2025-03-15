<?php

declare(strict_types=1);

namespace ArmorCMS\Page\Entity;

use ArmorCMS\Page\Repository\PageRepository;
use ArmorCMS\Shared\Trait\Blameable;
use ArmorCMS\Shared\Trait\Identifyable;
use ArmorCMS\Shared\Trait\SoftDeletable;
use ArmorCMS\Shared\Trait\Timestampable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table(name: "route")]
#[ORM\UniqueConstraint(name: "slug", columns: ["slug"])]
class Route
{
    use Identifyable;
    use Timestampable;
    use Blameable;
    use SoftDeletable;

    public function __construct(
        #[ORM\Column(type: UuidType::NAME)]
        private readonly Uuid $uuid,
        #[ORM\Column(type: Types::STRING, length: 255)]
        private string $slug
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function changeSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}