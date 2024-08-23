<?php
declare(strict_types=1);

namespace ArmorCMS\Web\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

final class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'user.email',
            ])
            ->add('isAdmin', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'checkbox-custom'],
                'label_attr' => ['class' => 'checkbox-custom-label'],
                'label' => 'user.is_admin',
            ])
            ->add('save', SubmitType::class);
    }
}