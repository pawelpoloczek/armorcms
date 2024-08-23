<?php
declare(strict_types=1);

namespace ArmorCMS\User\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class PutUserPassword
{
    public function __construct(
        #[Assert\Length(
            min: 5,
            max: 64,
            minMessage: 'Your password must be at least {{ limit }} characters long',
            maxMessage: 'Your password cannot be longer than {{ limit }} characters',
        )]
        public string $oldPassword,
        #[Assert\Length(
            min: 5,
            max: 64,
            minMessage: 'Your password must be at least {{ limit }} characters long',
            maxMessage: 'Your password cannot be longer than {{ limit }} characters',
        )]
        public string $newPassword,
    ) {
    }
}
