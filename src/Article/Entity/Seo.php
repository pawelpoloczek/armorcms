<?php
declare(strict_types=1);

namespace ArmorCMS\Article\Entity;

use ArmorCMS\Article\Repository\SeoRepository;
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
        private string $robots,
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
}