<?php
declare(strict_types=1);

namespace ArmorCMS\User\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class PutUser
{
    public function __construct(
        #[Assert\Length(
            min: 5,
            max: 255,
            minMessage: 'Your email must be at least {{ limit }} characters long',
            maxMessage: 'Your email cannot be longer than {{ limit }} characters',
        )]
        public string $email,
        public bool $isAdmin
    ) {
    }
}
