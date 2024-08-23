<?php
declare(strict_types=1);

namespace ArmorCMS\Shared\Service;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

use function sprintf;

final readonly class ImageResizer
{
    public function __construct(
        private array $thumbnailSizes,
        private Imagine $imagine
    ) {
    }

    public function createThumbnails(
        string $fileName,
        string $filePath
    ): void {
        foreach ($this->thumbnailSizes as $sizeName => $sizes) {
            $this->resize($fileName, $filePath, $sizeName, $sizes['width'], $sizes['height']);
        }
    }

    private function resize(
        string $fileName,
        string $filePath,
        string $sizeName,
        int $maxWidth,
        int $maxHeight
    ): void {
        $fileNameWithPath = sprintf('%s%s', $filePath, $fileName);
        [$imageWidth, $imageHeight] = getimagesize($fileNameWithPath);
        $ratio = $imageWidth / $imageHeight;
        $width = $maxWidth;
        $height = $maxHeight;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }

        $photo = $this->imagine->open($fileNameWithPath);
        $photo->resize(new Box($width, $height))->save(
            sprintf('%s%s/%s', $filePath, $sizeName, $fileName)
        );
    }
}
