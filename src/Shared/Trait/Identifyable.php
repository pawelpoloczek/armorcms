<?php
declare(strict_types=1);

namespace ArmorCMS\Shared\Trait;

use Doctrine\ORM\Mapping as ORM;

trait Identifyable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }
}
