<?php
declare(strict_types=1);

namespace ArmorCMS\User\Validator;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraint;

final class OldPasswordMatch extends Constraint
{
    public string $message = 'user.old_password_not_match';
    public string $mode = 'strict';

    public function __construct(
        public readonly ?Uuid $userUuid = null,
        ?string $mode = null,
        ?string $message = null,
        ?array $groups = null,
        $payload = null
    ) {
        parent::__construct([], $groups, $payload);

        $this->mode = $mode ?? $this->mode;
        $this->message = $message ?? $this->message;
    }
}