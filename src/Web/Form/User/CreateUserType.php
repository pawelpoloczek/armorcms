<?php
declare(strict_types=1);

namespace ArmorCMS\Web\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CreateUserType extends AbstractType
{
    public function __construct(
        private readonly TranslatorInterface $translator
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'user.username',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => $this->translator->trans('user.passwords_must_match'),
                'first_options' => ['label' => 'user.password'],
                'second_options' => ['label' => 'user.password_repeat'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'user.email',
            ])
            ->add('isAdmin', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'checkbox-custom'],
                'label_attr' => ['class' => 'checkbox-custom-label'],
                'label' => 'user.is_admin',
            ])
            ->add('avatar', FileType::class, [
                'required' => false,
                'label' => 'user.avatar',
            ])
            ->add('save', SubmitType::class);
    }
}