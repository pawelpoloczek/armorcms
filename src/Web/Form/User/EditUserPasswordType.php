<?php
declare(strict_types=1);

namespace ArmorCMS\Web\Form\User;

use ArmorCMS\User\Validator\OldPasswordMatch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

final class EditUserPasswordType extends AbstractType
{
    public function __construct(
        private readonly TranslatorInterface $translator
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'user.old_password',
                'constraints' => [new OldPasswordMatch($options['userUuid'])],
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => $this->translator->trans('user.passwords_must_match'),
                'first_options' => ['label' => 'user.new_password'],
                'second_options' => ['label' => 'user.new_password_repeat'],
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'userUuid' => null,
        ]);
    }
}