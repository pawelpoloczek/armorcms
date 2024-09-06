<?php
declare(strict_types=1);

namespace ArmorCMS\Shared\DTO;

final readonly class File
{
    public function __construct(
        public string $name,
        public string $fileName,
        public string $filePath
    ){
    }
}