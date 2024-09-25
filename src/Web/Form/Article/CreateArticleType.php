<?php
declare(strict_types=1);

namespace ArmorCMS\Web\Form\Article;

use ArmorCMS\Article\Enum\SeoRobots;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class CreateArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'article.title',
            ])
            ->add('slug', TextType::class, [
                'label' => 'article.slug',
            ])
            ->add('isActive', CheckboxType::class, [
                'attr' => ['class' => 'checkbox-custom'],
                'label_attr' => ['class' => 'checkbox-custom-label'],
                'label' => 'article.is_active',
            ])
            ->add('author', TextType::class, [
                'label' => 'article.author',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'article.content',
            ])
            ->add('seoTitle', TextType::class, [
                'label' => 'seo.title',
            ])
            ->add('seoDescription', TextType::class, [
                'label' => 'seo.description',
            ])
            ->add('robots', ChoiceType::class, [
                'label' => 'seo.robots',
                'expanded' => true,
                'multiple' => true,
                'choices' => array_column(SeoRobots::cases(), 'name', 'value'),
            ])
            ->add('seoOgTitle', TextType::class, [
                'label' => 'seo.ogTitle',
            ])
            ->add('seoOgDescription', TextType::class, [
                'label' => 'seo.ogDescription',
            ])
            ->add('seoOgSection', TextType::class, [
                'label' => 'seo.ogSection',
            ])
            ->add('seoOgTags', CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => [
                    'help' => 'You can edit this name here.',
                ],
                'prototype_options'  => [
                    'help' => 'You can enter a new name here.',
                ],
            ])
            ->add('save', SubmitType::class);
    }
}