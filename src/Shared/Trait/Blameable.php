<?php
declare(strict_types=1);

namespace ArmorCMS\Shared\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable as GedmoBlameable;

trait Blameable
{
    #[ORM\Column(type: Types::STRING)]
    #[GedmoBlameable(on: 'create')]
    protected ?string $createdBy = null;

    #[ORM\Column(
        type: Types::STRING,
        nullable: true,
        options: ["default" => null]
    )]
    #[GedmoBlameable(on: 'update')]
    protected ?string $updatedBy = null;

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }
}
