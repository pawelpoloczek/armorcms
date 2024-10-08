<?php
declare(strict_types=1);

namespace ArmorCMS\User\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateUser
{
    public function __construct(
        public Uuid $uuid,
        #[Assert\NotBlank]
        public string $username,
        #[Assert\Email(
            message: 'The email {{ value }} is not a valid email.',
        )]
        #[Assert\Length(
            min: 5,
            max: 255,
            minMessage: 'Your email must be at least {{ limit }} characters long',
            maxMessage: 'Your email cannot be longer than {{ limit }} characters',
        )]
        public string $email,
        #[Assert\Length(
            min: 5,
            max: 64,
            minMessage: 'Your password must be at least {{ limit }} characters long',
            maxMessage: 'Your password cannot be longer than {{ limit }} characters',
        )]
        public string $password,
        public bool $isAdmin,
        public ?UploadedFile $avatar
    ) {
    }
}
