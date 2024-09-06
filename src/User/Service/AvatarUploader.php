<?php
declare(strict_types=1);

namespace ArmorCMS\User\Service;

use ArmorCMS\Shared\DTO\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final readonly class AvatarUploader
{
    public function __construct(
        private string $userAvatarDirectory,
        private SluggerInterface $slugger
    ) {

    }

    public function upload(UploadedFile $file): File
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = strtolower((string)$this->slugger->slug($originalFilename));
        $uniqueFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        $file->move($this->userAvatarDirectory, $uniqueFilename);

        return new File(
            $originalFilename,
            $uniqueFilename,
            $this->userAvatarDirectory
        );
    }
}