<?php

declare(strict_types=1);

namespace ArmorCMS\Shared\Validator;

use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class UploadedImageValidator
{
    public function isValid(mixed $uploadedFile): bool
    {
        if (!$uploadedFile instanceof UploadedFile) {
            return false;
        }

        if (\UPLOAD_ERR_OK !== $uploadedFile->getError()) {
            return false;
        }

       if (false === in_array($uploadedFile->getMimeType(), ['image/jpeg', 'image/png'], true)) {
           return false;
       }

       return true;
    }
}
