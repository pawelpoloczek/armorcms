<?php
declare(strict_types=1);

namespace ArmorCMS\User\Validator;

use ArmorCMS\User\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class OldPasswordMatchValidator extends ConstraintValidator
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof OldPasswordMatch) {
            throw new UnexpectedTypeException($constraint, OldPasswordMatch::class);
        }

        if (null === $constraint->userUuid) {
            throw new InvalidArgumentException();
        }

        $user = $this->userRepository->findByUuid($constraint->userUuid);
        if (null === $user) {
            throw new InvalidArgumentException();
        }

        if ($this->passwordHasher->isPasswordValid($user, $value)) {
            return;
        }

        $this->context->buildViolation(new TranslatableMessage($constraint->message))
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}