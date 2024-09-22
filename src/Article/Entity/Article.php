<?php
declare(strict_types=1);

namespace ArmorCMS\Article\Entity;

use ArmorCMS\Article\Repository\ArticleRepository;
use ArmorCMS\Shared\Trait\Blameable;
use ArmorCMS\Shared\Trait\Identifyable;
use ArmorCMS\Shared\Trait\Timestampable;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'article')]
class Article
{
    use Identifyable;
    use Timestampable;
    use Blameable;

    public function __construct(
        #[ORM\Column(type: UuidType::NAME)]
        private readonly Uuid $uuid,
        #[ORM\Column(type: Types::STRING, length: 255)]
        private string $title,
        #[ORM\Column(type: Types::STRING, length: 255)]
        private string $slug,
        #[ORM\Column(type: Types::BOOLEAN)]
        private string $isActive,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private DateTimeImmutable $publicationDate,
        #[ORM\Column(type: Types::STRING, length: 127)]
        private string $author
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }
}