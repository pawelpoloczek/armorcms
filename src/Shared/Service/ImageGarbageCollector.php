<?php
declare(strict_types = 1);

namespace ArmorCMS\Shared\Service;

use Symfony\Component\Filesystem\Filesystem;

final class ImageGarbageCollector
{
    private Filesystem $filesystem;

    public function __construct(
        private readonly array $thumbnailSizes
    ) {
        $this->filesystem = new Filesystem();
    }

    public function cleanUp(string $path, string $fileName): void
    {
        foreach ($this->thumbnailSizes as $thumbnailName => $thumbnailSize) {
            $filepath = sprintf(
                '%s/%s/%s',
                $path,
                $thumbnailName,
                $fileName
            );

            if ($this->filesystem->exists($filepath)) {
                $this->filesystem->remove($filepath);
            }
        }
    }
}