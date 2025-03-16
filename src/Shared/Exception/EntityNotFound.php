<?php

declare(strict_types=1);

namespace ArmorCMS\Shared\Exception;

use Exception;
use Symfony\Component\Uid\Uuid;

final class EntityNotFound extends Exception
{
    public function __construct(
        Uuid $entityUuid,
        string $entityClassName,
    ) {
        parent::__construct(
            message: sprintf(
                'Entity: %s with id: %s was not found',
                $entityClassName,
                $entityUuid,
            )
        );
    }
}
