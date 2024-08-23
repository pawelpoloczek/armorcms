<?php
declare(strict_types=1);

namespace ArmorCMS\Shared\Repository;

interface IterableRepositoryInterface
{
    public function findAllIterable(): iterable;
}