<?php

declare(strict_types=1);

namespace ArmorCMS\TextBlock\Entity;

use ArmorCMS\Shared\Trait\Blameable;
use ArmorCMS\Shared\Trait\Identifyable;
use ArmorCMS\Shared\Trait\SoftDeletable;
use ArmorCMS\Shared\Trait\Timestampable;
use ArmorCMS\TextBlock\Repository\TextBlockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity(repositoryClass: TextBlockRepository::class)]
#[ORM\Table(name: "text_block")]
class TextBlock
{
    use Identifyable;
    use Timestampable;
    use Blameable;
    use SoftDeletable;

    public function __construct(
        #[ORM\Column(type: UuidType::NAME)]
        private readonly Uuid $uuid,
        #[ORM\Column(type: Types::STRING, length: 63, unique: true)]
        #[Regex(
            pattern: "/^[a-z-]+$/",
            message: "To pole może zawierać tylko małe litery (a-z) oraz myślnik (-)."
        )]
        private string $blockKey,
        #[ORM\Column(type: Types::BOOLEAN)]
        private bool $isActive,
        #[ORM\Column(type: Types::TEXT)]
        private string $content,
        #[ORM\Column(type: Types::TEXT, nullable: true)]
        private ?string $description,
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getBlockKey(): string
    {
        return $this->blockKey;
    }

    public function changeBlockKey(string $blockKey): void
    {
        $this->blockKey = $blockKey;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function changeActivity(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function changeContent(string $content): void
    {
        $this->content = $content;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function changeDescription(string $description): void
    {
        $this->description = $description;
    }
}