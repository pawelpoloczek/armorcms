<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Form\Page;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateTextBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'textblock.title',
            ])
            ->add('isActive', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'checkbox-custom'],
                'label_attr' => ['class' => 'checkbox-custom-label'],
                'label' => 'textblock.is_active',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'page.content',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'To pole nie może być puste.',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'textblock.description',
                'required' => false,
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}