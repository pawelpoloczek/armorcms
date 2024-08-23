<?php

declare(strict_types=1);

namespace ArmorCMS\Shared\Service;

use function sprintf;

final readonly class FilenameGenerator
{
    public function generate(string $prefix): string
    {
        return sprintf('%s.%s', uniqid($prefix, true), 'png');
    }
}
