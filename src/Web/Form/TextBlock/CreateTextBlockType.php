<?php

declare(strict_types=1);

namespace ArmorCMS\Web\Form\TextBlock;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

final class CreateTextBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('blockKey', TextType::class, [
                'label' => 'textblock.blockKey',
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 63]),
                    new Regex([
                        'pattern' => "/^[a-z-]+$/",
                        'message' => "To pole może zawierać tylko małe litery (bez polskich znaków) oraz myślnik (-).",
                    ]),
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'checkbox-custom'],
                'label_attr' => ['class' => 'checkbox-custom-label'],
                'label' => 'textblock.is_active',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'textblock.content',
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