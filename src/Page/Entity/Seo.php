<?php
declare(strict_types=1);

namespace ArmorCMS\Page\Entity;

use ArmorCMS\Page\Repository\SeoRepository;
use ArmorCMS\Shared\Trait\Blameable;
use ArmorCMS\Shared\Trait\Identifyable;
use ArmorCMS\Shared\Trait\Timestampable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SeoRepository::class)]
#[ORM\Table(name: 'seo')]
class Seo
{
    use Identifyable;
    use Timestampable;
    use Blameable;

    public function __construct(
        #[ORM\Column(type: UuidType::NAME)]
        private readonly Uuid $uuid,
        #[ORM\Column(type: Types::STRING, length: 127)]
        private string $title,
        #[ORM\Column(type: Types::STRING, length: 255)]
        private string $description,
        #[ORM\Column(type: Types::JSON)]
        private array $robots,
        #[ORM\Column(type: Types::STRING, length: 127)]
        private string $ogTitle,
        #[ORM\Column(type: Types::STRING, length: 255)]
        private string $ogDescription,
        #[ORM\Column(type: Types::STRING, length: 127)]
        private string $ogSection,
        #[ORM\Column(type: Types::JSON)]
        private array $ogTags
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function changeDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getRobots(): array
    {
        return $this->robots;
    }

    public function changeRobots(array $robots): void
    {
        $this->robots = $robots;
    }

    public function getOgTitle(): string
    {
        return $this->ogTitle;
    }

    public function changeOgTitle(string $ogTitle): void
    {
        $this->ogTitle = $ogTitle;
    }

    public function getOgDescription(): string
    {
        return $this->ogDescription;
    }

    public function changeOgDescription(string $ogDescription): void
    {
        $this->ogDescription = $ogDescription;
    }

    public function getOgSection(): string
    {
        return $this->ogSection;
    }

    public function changeOgSection(string $ogSection): void
    {
        $this->ogSection = $ogSection;
    }

    public function getOgTags(): array
    {
        return $this->ogTags;
    }

    public function changeOgTags(array $ogTags): void
    {
        $this->ogTags = $ogTags;
    }
}